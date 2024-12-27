# Database Design Documentation

This document provides a detailed overview of the database schema and relationships for the project, describing the tables, fields, and relationships between them.

---

## **Tables and Schema**

### **1. `users` Table**

This table stores information about users in the system.

|Field Name|Type|Attributes|Description|
|---|---|---|---|
|`id`|`bigint`|Primary Key, Auto Increment|Unique identifier for each user.|
|`name`|`string`||The user's name.|
|`email`|`string`|Unique|The user's email address.|
|`email_verified_at`|`timestamp`|Nullable|Timestamp when the email was verified.|
|`password`|`string`||The user's password.|
|`description`|`text`|Nullable|A brief description of the user.|
|`profile`|`string`|Nullable|URL or path to the user's profile picture.|
|`role`|`enum`|Values: 'user', 'admin'|Role of the user in the system.|
|`remember_token`|`string`|Nullable|Token for "remember me" functionality.|
|`created_at`|`timestamp`|Default: current timestamp|Record creation timestamp.|
|`updated_at`|`timestamp`|Default: current timestamp|Record last update timestamp.|

---

### **2. `skills` Table**

This table stores a list of skills that can be associated with users.

|Field Name|Type|Attributes|Description|
|---|---|---|---|
|`id`|`bigint`|Primary Key, Auto Increment|Unique identifier for each skill.|
|`name`|`string`|Length: 50|Name of the skill.|
|`description`|`text`|Nullable|Detailed description of the skill.|
|`created_at`|`timestamp`|Default: current timestamp|Record creation timestamp.|
|`updated_at`|`timestamp`|Default: current timestamp|Record last update timestamp.|

---

### **3. `user_skills` Table**

This table establishes the relationship between users and their skills.

|Field Name|Type|Attributes|Description|
|---|---|---|---|
|`id`|`bigint`|Primary Key, Auto Increment|Unique identifier for each user-skill mapping.|
|`name`|`string`|Length: 50|Name of the user skill.|
|`description`|`text`|Nullable|Description of the user skill.|
|`user_id`|`bigint`|Foreign Key|References the `id` field in the `users` table.|
|`created_at`|`timestamp`|Default: current timestamp|Record creation timestamp.|
|`updated_at`|`timestamp`|Default: current timestamp|Record last update timestamp.|

---

### **4. `projects` Table**

This table stores information about projects managed by users.

|Field Name|Type|Attributes|Description|
|---|---|---|---|
|`id`|`bigint`|Primary Key, Auto Increment|Unique identifier for each project.|
|`title`|`string`||Title of the project.|
|`description`|`text`||Detailed description of the project.|
|`user_id`|`bigint`|Foreign Key|References the `id` field in the `users` table.|
|`start_date`|`date`|Nullable|The start date of the project.|
|`end_date`|`date`|Nullable|The end date of the project.|
|`status`|`enum`|Values: 'open', 'in_progress', 'completed', 'close'|The current status of the project.|
|`created_at`|`timestamp`|Default: current timestamp|Record creation timestamp.|
|`updated_at`|`timestamp`|Default: current timestamp|Record last update timestamp.|

---

### **5. `collaborations` Table**

This table manages collaborations between users and projects.

|Field Name|Type|Attributes|Description|
|---|---|---|---|
|`id`|`bigint`|Primary Key, Auto Increment|Unique identifier for each collaboration.|
|`project_id`|`bigint`|Foreign Key|References the `id` field in the `projects` table.|
|`user_id`|`bigint`|Foreign Key|References the `id` field in the `users` table.|
|`role`|`string`|Nullable|Role of the collaborator in the project.|
|`status`|`enum`|Values: 'pending', 'accepted', 'declined'|The status of the collaboration request.|
|`created_at`|`timestamp`|Default: current timestamp|Record creation timestamp.|
|`updated_at`|`timestamp`|Default: current timestamp|Record last update timestamp.|

---

### **6. `project_skill` Table**

This table represents the many-to-many relationship between projects and skills.
|Field Name|Type|Attributes|Description|
|---|---|---|---|
|`id`|`bigint`|Primary Key, Auto Increment|Unique identifier for each collaboration.|
|`project_id`|`bigint`|Foreign Key|References the `id` field in the `projects` table.|
|`skill_id` |`bigint`|Foreign Key|References the `id` field in the `skills` table.|
|`created_at`|`timestamp`|Default: current timestamp|Record creation timestamp.|
|`updated_at`|`timestamp`|Default: current timestamp|Record last update timestamp.|


## **Relationships**

### **1. User Relationships**

- **One-to-Many with `projects`:** Each user can create multiple projects.
- **One-to-Many with `user_skills`:** Each user can have multiple skills.
- **Many-to-Many with `projects` (via `collaborations`):** Users can collaborate on multiple projects.

### **2. Project Relationships**

- **One-to-Many with `collaborations`:** A project can have multiple collaborators.
- **Belongs-To with `users`:** Each project is created by a single user.

### **3. Skills and User Skills**

- **One-to-Many with `user_skills`:** Skills can be linked to multiple users.

  
