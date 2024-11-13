# Project Documentation

## Overview

This project encompasses a set of features designed for logging user actions, managing system events, handling user profile updates, and providing essential user authentication functionalities. We implemented APIs for registering users, logging in, updating profiles, and performing various system-related tasks. The system also provides logging for user actions and system events, with access control in place for certain functionalities. Below is an overview of the completed tasks.

---

## Table of Contents

1. [API Endpoints](#api-endpoints)
   - Register
   - Login
   - Update Profile
   - Artisan Command
   - Fetch System Events & User Actions (Admin Only)
2. [Audit and System Events](#audit-and-system-events)
   - User Actions Logging
   - System Events Logging
   - Cache Clearing Event Logging
3. [User Profile Update](#user-profile-update)
4. [Test Cases](#test-cases)
   - Storing User Actions
   - Fetching System Events
   - Cache Clearing Event

---

## 1. API Endpoints

### 1.1 Register

- **Endpoint**: `POST /register`
- **Description**: Registers a new user by accepting their `name`, `email`, and `password`. The request is validated, and the user is created in the system. A confirmation response is returned upon success.
- **Request Payload**:
    - `name` (string, required)
    - `email` (string, required)
    - `password` (string, required)
    - `password_confirmation` (string, required)
- **Response**: 
    - `message`: Confirmation of successful registration.

### 1.2 Login

- **Endpoint**: `POST /login`
- **Description**: Authenticates the user using their `email` and `password`. A successful login returns a token, which is used for subsequent authenticated requests.
- **Request Payload**:
    - `email` (string, required)
    - `password` (string, required)
- **Response**: 
    - `token`: A JWT token for authenticated requests.
    - `message`: Confirmation of successful login.

### 1.3 Update Profile

- **Endpoint**: `PUT /update-profile/{id}`
- **Description**: Allows the user to update their profile information (e.g., name, email, and profile image). The request validates the data before updating.
- **Request Payload**:
    - `name` (string, required)
    - `email` (string, required, must be unique for other users)
    - `profile_image` (file, optional, image type)
- **Response**: 
    - `message`: Confirmation of successful profile update.

### 1.4 Artisan Command (Cache Clearing)

- **Endpoint**: `POST /clear-cache`
- **Description**: Clears the system cache and logs the action as a system event. This action is performed using an Artisan command and also triggers event logging.
- **Response**:
    - `message`: Confirmation that the cache was cleared successfully.
    - **Admin Access**: Only accessible by admin users. 

### 1.5 Fetch System Events (Admin Only)

- **Endpoint**: `GET /system-events`
- **Description**: Fetches all system events (e.g., cache clearing, system updates) logged in the system. This is an admin-only feature, ensuring that only administrators can access sensitive system logs.
- **Response**: 
    - `data`: A collection of system events (e.g., event type, description, timestamp).

### 1.6 Fetch User Actions (Admin Only)

- **Endpoint**: `GET /user-actions`
- **Description**: Fetches all user actions (e.g., logins, profile updates) performed by users. This endpoint is also admin-only, ensuring that only administrators can view the history of user actions.
- **Response**: 
    - `data`: A collection of user actions (e.g., action type, user ID, description, timestamp).

---

## 2. Audit and System Events

### 2.1 User Actions Logging

We implemented functionality to track and log **user actions** (e.g., logins, profile updates) in the system. This is achieved through the `AuditService`, where the user actions are stored and fetched as needed.

- **Storing User Actions**: When a user performs an action, it is stored in the database for auditing purposes.
- **Fetching User Actions**: The system allows fetching user actions with optional filters, providing a detailed history of actions performed by users.

### 2.2 System Events Logging

System events such as cache clearing or configuration changes are logged to keep track of critical system activities. These events can be used for debugging and monitoring system performance.

- **Storing System Events**: When certain critical actions are performed (e.g., cache clearing), the system stores these actions as system events.
- **Fetching System Events**: Similar to user actions, system events can be retrieved for monitoring purposes.

### 2.3 Cache Clearing Event Logging

We implemented a function that clears the system cache and simultaneously logs the event as a system activity. This allows tracking of when the cache was cleared, which is vital for maintenance and troubleshooting.

- **Clear Cache**: When the cache is cleared, the event is logged in the system to track this action.
- **Logging the Cache Clearing Event**: The event includes details like the type of event, description, additional event data (e.g., cache type), and the triggering IP address.

---

## 3. User Profile Update

### 3.1 Profile Update

The system allows users to update their profiles, including their name, email, and profile image. Each update is validated, and if the profile is successfully updated, a **SystemEvent** is logged to record the profile change.

- **Profile Validation**: Incoming requests for profile updates are validated to ensure data integrity (e.g., valid email, correct file format for profile image).
- **Profile Update Logging**: Once the profile update is successful, a system event is logged with details of the update, including the user’s ID, name, and the event type.

---

## 4. Test Cases

### 4.1 Test Case for Storing User Actions

Test cases were written to verify that user actions are stored correctly in the database. This includes:
- Validating that a user action is properly stored after a request.
- Ensuring that the response contains the expected data structure.
- Confirming the data is correctly inserted into the database.

### 4.2 Test Case for Fetching System Events

Test cases for fetching system events ensure that the system can retrieve events accurately. This includes:
- Verifying that the response is successful and contains the correct data structure for system events.
- Ensuring that all relevant system events are returned and properly formatted.

### 4.3 Test Case for Cache Clearing Event

Test cases were also written to ensure that cache clearing events are logged correctly. This includes:
- Confirming that when the cache is cleared, a system event is logged.
- Ensuring that the event is stored with the correct event type and description.
- Verifying that the cache clearing process works without errors.

---

## Conclusion

This project provides a robust system for tracking and managing user actions, logging critical system events, and allowing users to update their profiles securely. The implemented features ensure that all important actions are logged for auditing purposes, and the system is equipped with detailed logs for future troubleshooting and monitoring. Additionally, the API endpoints for registering, logging in, and updating profiles provide a secure foundation for managing user data.

Test cases ensure the correctness of each feature, verifying that actions are logged, events are triggered, and APIs function as expected.

---

## Future Improvements

- **Enhance Event Handling**: We can further optimize event handling by adding more granular event types and improving the filtering options for events.
- **User Notifications**: Introducing user notifications for specific actions like profile updates, login alerts, etc., could further enhance the user experience.
- **Performance Monitoring**: Adding more detailed logging for performance-related events could help in identifying and mitigating system bottlenecks.

