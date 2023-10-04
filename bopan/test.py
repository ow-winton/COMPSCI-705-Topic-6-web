# 导入所需的库和模型
import joblib
import pandas as pd

# 加载已训练的模型和标签编码器
clf = joblib.load('trained_decision_tree.pkl')
label_encoder = joblib.load('label_encoder.pkl')

# 创建一个包含未知数据的DataFrame
# 假设未知数据包括文件名、文件扩展名、文件大小、最后修改日期和标签（这里标签可以是任何值，因为我们要预测它）
unknown_data = pd.DataFrame({
    'file_name': ['unknown_file.txt'],  # 未知文件名
    'file_extension': ['.txt'],          # 未知文件扩展名
    'file_size': [1000],                # 未知文件大小
    'last_modified_date': [1632201600], # 未知最后修改日期的时间戳
    'tag': ['unknown']                  # 未知标签，可以是任何值
})

# 使用标签编码器将字符串特征编码为数值特征
unknown_data['file_name'] = label_encoder.transform(unknown_data['file_name'])
unknown_data['file_extension'] = label_encoder.transform(unknown_data['file_extension'])
unknown_data['tag'] = label_encoder.transform(unknown_data['tag'])

# 使用模型进行预测
predicted_label = clf.predict(unknown_data[['file_name', 'file_extension', 'file_size', 'last_modified_date', 'tag']])

# 输出预测结果
print(f"Predicted Label: {predicted_label[0]}")
