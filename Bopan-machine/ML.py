import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier
from sklearn.metrics import accuracy_score
import numpy as np
import os
from sklearn.tree import export_graphviz

# 读取CSV文件
df = pd.read_csv('dataset.csv')


# 转换文件大小字符串为数值（以MB为单位）
def parse_file_size(size_str):
    if 'MB' in size_str:
        return float(size_str.replace('MB', ''))
    elif 'KB' in size_str:
        return float(size_str.replace('KB', '')) / 1000
    else:
        return 0.0  # 如果无法解析，返回0


df['file_size'] = df['file_size'].apply(parse_file_size)

# 对其他字符串特征进行独热编码
df_encoded = pd.get_dummies(df, columns=['filename', 'file_extension', 'user_tag'])

# 提取特征和标签
X = df_encoded.drop(columns=['label'])
y = df_encoded['label']

# 划分训练集和测试集
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# 创建一个决策树分类器
dt_classifier = DecisionTreeClassifier()

# 训练模型
dt_classifier.fit(X_train, y_train)

# 预测测试集
y_pred = dt_classifier.predict(X_test)

# 计算预测准确率
accuracy = accuracy_score(y_test, y_pred)
print("Accuracy:", accuracy)


# 后剪枝
def prune_tree(tree, alpha, X_val, y_val, node_id=0):
    if tree.children_left[node_id] == -1:  # 叶节点
        return

    # 后序遍历剪枝
    prune_tree(tree, alpha, X_val, y_val, tree.children_left[node_id])
    prune_tree(tree, alpha, X_val, y_val, tree.children_right[node_id])

    n_leaves = np.sum(tree.children_left[node_id] == -1)
    score_before = dt_classifier.score(X_val, y_val)

    # 剪枝
    tree.children_left[node_id] = -1
    tree.children_right[node_id] = -1
    score_after = dt_classifier.score(X_val, y_val)

    # 根据验证集准确率进行剪枝
    if score_after >= (1 - alpha) * score_before:
        print(f"Pruned {n_leaves} leaves.")


alpha = 0.01  # 剪枝参数
prune_tree(tree=dt_classifier.tree_, alpha=alpha, X_val=X_test, y_val=y_test)

# 生成决策树图
export_graphviz(dt_classifier, out_file='decision_tree_pruned.dot',
                feature_names=X.columns, class_names=y.unique(), filled=True)

# 使用Graphviz将.dot文件转换为图像文件（需要Graphviz软件支持）
os.system("dot -Tpng decision_tree_pruned.dot -o decision_tree_pruned.png")
os.system("dot -Tpdf decision_tree_pruned.dot -o decision_tree_pruned.pdf")
