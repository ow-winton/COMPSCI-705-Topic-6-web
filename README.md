# Project Description

This project involves the development of a Personal Information Management (PIM) system that incorporates machine learning and cloud technology. The primary goal of this project is to enhance user-machine interaction at multiple levels.

**GitHub Repository:** [https://github.com/ow-winton/COMPSCI-705-Topic-6-web/tree/main](https://github.com/ow-winton/COMPSCI-705-Topic-6-web/tree/main)

The main functionalities of this project are located in the `main` branch of the GitHub project. However, the machine learning features, which are not yet successfully integrated, are stored in the `bopan-machine` branch: [https://github.com/ow-winton/COMPSCI-705-Topic-6-web/tree/bopan-machine](https://github.com/ow-winton/COMPSCI-705-Topic-6-web/tree/bopan-machine).

## Installation

This system is a web-based management system based on cloud technology, eliminating the need for additional installations. Users can access the system using the following IP address, eliminating installation and environment hassles to improve user experience. If you wish to deploy the project locally, please refer to the "Deploying the project to local path.docx" file in the folder.

Regarding the machine learning functionality, since it has not been successfully integrated into the system, it needs to be experienced separately using an IDE editor in a Python 3 environment.

## Project Features

### User Management

1. **User Registration (Implemented):** Users can register their personal accounts to manage and view their personal information. This differentiation is essential for managing user permissions effectively.

2. **User Login (Implemented):** After registering an account, users can log in to the system to view their stored file information.

3. **User Logout (Implemented):** Users have the option to log out of the system. However, files will still be stored in the database, and they can still be accessed in the next login session.

### Personal Information Management (PIM)

4. **File Storage (Implemented):** Users can upload their personal files, which are stored in the database. Users can view the status of their stored files and perform editing operations on them.

5. **File Download (Implemented):** This cloud-based PIM system allows users to download files to manage them on different devices.

6. **File Tagging (Implemented):** Users can tag their files with custom tags when uploading them, enabling simple file categorization. Initially, these tags were intended to assist machine learning models in file classification.

7. **File Retrieval by Tag (Implemented):** Users can filter and retrieve files tagged with specific tags, significantly improving file retrieval efficiency.

8. **Cloud Storage File Management (Implemented):** By deploying this project on a cloud platform, any user can access the system via a domain name or IP address and manage files across different devices.

9. **Favorite Files (Functionality Implemented, Not Integrated):** The system allows users to mark their favorite or frequently used files as "favorites." Searching for these files using the "favorite" tag can enhance user file management efficiency. This feature has been developed but has not yet been integrated into the main project.

10. **File Classification by Tags and Information (Implemented, Not Integrated):** This functionality involves classifying files based on file information (e.g., file name, file size) and user-input tags as classifier features. For a detailed implementation, please refer to the "Machine learning implementation.mp4" file in the attachments. However, this feature has not yet been integrated into the PIM system for the following reasons:

   - Technical Issues: Integrating machine learning, which requires Python, into a PHP-based project has encountered technical challenges, and integration has not been successful.
   - Limitations of Machine Learning Models: Machine learning models rely on training with existing data and can only classify data they have been trained on. This limitation makes them less effective for classifying entirely unknown data, such as personal information. Additionally, the lack of suitable large datasets for personal information further hinders this approach.
   - Choice of Models: Choosing the appropriate machine learning model is a significant challenge due to the time cost associated with complex models. Complex models would lead to longer classification times, which contradicts the goal of improving user efficiency.
   - Privacy Concerns: User privacy is paramount when dealing with personal files, and using file content for classification is ethically problematic. Therefore, personal file content cannot be used for classification.
   - Limited Meaningful Features: Many personal files have non-informative file names, such as camera photos that are only related to time and camera model, lacking meaningful classification features. Consequently, the machine learning model would rely solely on user-input tags for classification, which limits its performance.

For further details on the machine learning implementation, please refer to the "Machine learning implementation.mp4" file in the attachments.

Please note that while certain functionalities are implemented, they have not been fully integrated into the main project due to the reasons outlined above.
