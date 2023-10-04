import os
import csv
import datetime

# 指定要遍历的目录路径
directory_path = 'E:/705ml'

# 创建CSV文件并写入表头
csv_file_path = 'file_info.csv'
with open(csv_file_path, 'w', newline='') as csvfile:
    fieldnames = ['file_name', 'file_extension', 'file_size', 'last_modified_date']
    writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
    writer.writeheader()

    # 遍历目录并获取文件信息
    for root, _, files in os.walk(directory_path):
        for file in files:
            file_path = os.path.join(root, file)
            file_name, file_extension = os.path.splitext(file)
            try:
                file_size = os.path.getsize(file_path)
                last_modified = os.path.getmtime(file_path)
                last_modified_date = datetime.datetime.fromtimestamp(last_modified)

                # 将文件信息写入CSV文件
                writer.writerow({'file_name': file_name, 'file_extension': file_extension, 'file_size': file_size,
                                 'last_modified_date': last_modified_date})
            except Exception as e:
                print(f"无法获取文件信息：{file_path} - 错误：{str(e)}")

print(f"文件信息已写入到 {csv_file_path}")
