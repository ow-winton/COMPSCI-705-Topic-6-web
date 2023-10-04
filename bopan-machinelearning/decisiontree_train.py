import pandas as pd
from datetime import datetime
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier
from sklearn.metrics import accuracy_score
from sklearn.preprocessing import LabelEncoder, OneHotEncoder
import graphviz
from sklearn import tree
import joblib

# 读取CSV文件到DataFrame
data = pd.read_csv('file_information.csv')
class_names = data['label'].unique()

# 将标签列 'label' 作为目标变量
X = data[['file_name', 'file_extension', 'file_size', 'last_modified_date', 'tag']]
y = data['label']

# 使用独热编码对分类特征进行处理
X_encoded = pd.get_dummies(X, columns=['file_name', 'file_extension', 'tag'], drop_first=True)

# 将日期转换为时间戳
X_encoded["last_modified_date"] = pd.to_datetime(X_encoded["last_modified_date"]).apply(lambda x: datetime.timestamp(x))

# 划分数据集为训练集和测试集
X_train, X_test, y_train, y_test = train_test_split(X_encoded, y, test_size=0.2, random_state=42, shuffle=True)

# 创建决策树分类器
clf = DecisionTreeClassifier(random_state=42)

# 训练模型
clf.fit(X_train, y_train)

# 在测试集上进行预测
y_pred = clf.predict(X_test)

# 计算模型的准确率
accuracy = accuracy_score(y_test, y_pred)
print(f"decision_tree accuracy：{accuracy}")

# 保存训练好的模型为文件
model_filename = 'trained_decision_tree.pkl'
joblib.dump(clf, model_filename)

# 生成决策树的DOT格式描述文件
dot_data = tree.export_graphviz(clf, out_file=None, feature_names=X_encoded.columns,
                                class_names=class_names, filled=True, rounded=True,
                                special_characters=True)

# 使用graphviz库将DOT格式描述文件转换为图像
graph = graphviz.Source(dot_data)

# 保存决策树图像为文件
graph.render("decision_tree")

# 如果需要显示图像，可以使用以下代码
graph.view()