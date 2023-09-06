import os
import csv


def list_files_in_directory(directory):
    file_list = []

    for root, dirs, files in os.walk(directory):
        for file in files:
            file_name, file_extension = os.path.splitext(file)
            parent_folder = os.path.basename(root)
            file_list.append((file_name, file_extension, parent_folder))

    return file_list


def write_to_csv(file_list, csv_filename):
    with open(csv_filename, 'w', newline='') as csvfile:
        csv_writer = csv.writer(csvfile)
        csv_writer.writerow(['File Name', 'File Extension', 'Parent Folder'])
        csv_writer.writerows(file_list)


if __name__ == "__main__":
    input_directory = input("请输入文件夹路径：")
    csv_output_filename = "file_info.csv"

    files = list_files_in_directory(input_directory)
    write_to_csv(files, csv_output_filename)

    print("CSV文件已生成：", csv_output_filename)
