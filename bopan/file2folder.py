import os
from datetime import datetime
import joblib
import tkinter as tk
from tkinter import filedialog
import pandas as pd
import shutil  # 导入shutil库

def select_and_process_file():
    # 创建一个Tkinter根窗口并隐藏它，以便弹出文件对话框
    root = tk.Tk()
    root.withdraw()

    # 打开文件选择对话框，允许用户选择文件
    file_path = filedialog.askopenfilename(title="选择文件")

    if file_path:
        # 获取用户输入的标签
        tag = input("请输入标签: ")

        # 打开目标文件夹选择对话框，允许用户选择目标文件夹
        target_folder = filedialog.askdirectory(title="选择目标文件夹")

        # 关闭Tkinter窗口
        root.destroy()

        if target_folder:
            # 使用所选文件的路径和用户输入的标签和目标文件夹路径进行后续处理
            process_file(file_path, tag, target_folder)

def process_file(file_path, tag, target_folder):
    # 示例：从文件路径中提取文件名和扩展名
    file_name = os.path.splitext(os.path.basename(file_path))[0]
    file_extension = os.path.splitext(os.path.basename(file_path))[1]

    # 构建file_info字典
    file_info = {
        'file_name': file_name,
        'file_extension': file_extension,
        'file_size': os.path.getsize(file_path),
        'last_modified_date': datetime.fromtimestamp(os.path.getmtime(file_path)),
        'tag': tag  # 使用用户输入的标签
    }

    # 将文件信息构建为DataFrame
    file_df = pd.DataFrame([file_info])

    clf = joblib.load('trained_decision_tree.pkl')  # 加载 DecisionTreeClassifier 模型

    # 创建目标文件夹，如果不存在的话
    if not os.path.exists(target_folder):
        os.makedirs(target_folder)

    # 检查标签对应的子文件夹是否存在，如果不存在则创建
    label_folder = os.path.join(target_folder, tag)
    if not os.path.exists(label_folder):
        os.makedirs(label_folder)

    # 构造移动后的文件路径
    destination_file_path = os.path.join(label_folder, os.path.basename(file_path))

    # 移动文件到目标文件夹中
    shutil.copy(file_path, destination_file_path)

    print(f"文件已移动到文件夹：{label_folder}")

# 调用选择文件并处理的函数
select_and_process_file()
