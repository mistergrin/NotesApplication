# 📝 NotesApplication

**Notes Application** is a web-based system that allows registered users to **create, manage, and organize personal notes** with optional image attachments.  
The application also includes **user profile management** and an **administrative panel** for managing users.

The system supports **User** and **Admin** roles with different access levels.

🔗 **Live Demo:** [https://zwa.toad.cz/~hryshiva/site/](https://zwa.toad.cz/~hryshiva/site/)

## 🔐 Registration
- Users can register with a **unique nickname**
- **Validation:**
    - First name
    - Last name
    - Password
- Passwords are securely stored using `password_hash`

---

## 🔑 Login
- Users authenticate using **nickname** and **password**
- Credentials are verified using `password_verify`
- User data is stored in **PHP sessions**

---

## 👥 Roles

### 🚫 Guest
- Cannot access protected pages
- Automatically redirected to the login page

### 👤 User
- Can create, edit, and delete their own notes
- Can edit personal profile information

### 🛠 Admin
- Has access to the **Admin Panel**
- Can view all users
- Can promote users to Admin
- Can delete users (**except other Admins**)


## 🚀 Navigation

### Authenticated users
- **Main page**
- **Create a Note**
- **Your Profile**
- **Logout**
- **Admin Panel** *(Admin only)*

### Unauthenticated users
- **Login**
- **Registration**

> Navigation elements are dynamically displayed based on authentication status and user role.

---

## 👤 User Profile

Users can:

### View:
- Nickname
- First name
- Last name
- Role

### Edit:
- Nickname *(must remain unique)*
- First name
- Last name

> Profile updates are handled via AJAX and validated on the server side.

---

## 📝 Notes Management

### Create Note
Users can:
- Enter note text *(maximum 3000 characters)*
- Upload an optional image
- Creation date is automatically assigned

### Edit Note
Users can:
- Modify note text
- Replace the attached image

> When a note is updated:
> - The `updated_at` timestamp is set
> - The previous image file is deleted from the server

### Delete Note
- Deleting a note also removes its associated image file (if present)

### Notes Display
- Notes are sorted by:
    - `updated_at` (if available)
    - Otherwise by creation date
- Server-side pagination is applied

---

## 🛠 Admin Panel

**Accessible only to users with the ADMIN role.**

### Admin capabilities:
- View a paginated list of all users
- Promote a user to Admin
- Delete users:
    - All notes created by the user are removed
    - All images associated with the user's notes are deleted
- Admin users cannot delete other Admins

## 📄 Pagination

- Implemented for:
    - Notes list
    - Users list
- Server responses include pagination metadata:

```json
{
  "items": [],
  "total": 20,
  "page": 1,
  "pages": 4
}
```

## 📁 File Uploads

- **Supported uploads:** Images attached to notes
- **Validation:**
    - Server-side MIME type validation
    - Allowed formats: JPEG, PNG, GIF, JPG
- **Storage:** `storage/uploads/`
- Uploaded files are deleted when the related note or user is removed

---

## 🔒 Access Control

- Authentication state controlled via PHP sessions
- Unauthorized access results in server-side redirection
- UI actions are hidden if the user lacks permissions
- All sensitive operations are validated on the server

---

## 🏗 Architecture

The project follows the **MVC (Model–View–Controller)** architecture.

### Models
- Represent entities and business logic
- **Responsibilities:**
    - Data structure definition
    - Conversion to/from arrays
    - Encapsulation of entity behavior
- **Examples:** `User`, `Note`

### Controllers
- Handle HTTP requests, input validation, database interactions, JSON responses
- **Examples:** `UserController`, `NoteController`

### Database Layer
- File-based JSON storage system
- **Classes:** `UsersDB`, `NotesDB`
- **Responsibilities:**
    - CRUD operations
    - Pagination
    - Sorting
    - Reading and writing JSON files

### Views
- PHP-based HTML pages
- **Responsibilities:**
    - Rendering UI
    - Session checks
    - Loading client-side scripts

### 💻 Client-side (JavaScript)
- AJAX form submission
- Dynamic content updates
- Error handling
- Pagination
- Modal dialogs
- Dynamic generation of **note cards**
- Dynamic generation of **tables in the Admin Panel**


## 📚 Documentation

- **Technical Documentation:** Generated using phpDocumentor, located in `/docs`
- **Product / User Documentation:** Describes features, UI behavior, and user roles; intended for supervisors and non-technical stakeholders