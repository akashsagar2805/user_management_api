# User Management API


---

## Endpoints

### 1. **Create Account**

- **Endpoint**: `/api/create-account`
- **Method**: `POST`
- **Payload**:
  ```json
  {
        "name": "John Doe",
        "email": "john@example.com",
        "mobile_no": "1234567890",
        "password": "password123",
        "address_1": "123 Main St",
        "address_2": "Apt 101",
        "city": "New York",
        "state": "NY",
        "pincode": "10001"
  }

- **Response**:

  ```json
  {
      "status": "success",
      "message": "Account created successfully"
  }

- **Failure**:

  ```json
  {
      "status": "error",
      "errors": {
        "email": ["The email has already been taken."]
      }
  }



### 2. **Validate Account**

- **Endpoint**: `/api/validate-account`
- **Method**: `POST`
- **Payload**:
  ```json
  {
       "user_id": 1,
       "password": "password123"
  }

- **Response**:

  ```json
  {
      "status": "success",
      "message": "Account validated successfully",
      "token": "generated-auth-token"
  }

- **Failure**:

  ```json
     {
          "status": "error",
          "message": "Invalid credentials"
     }

### 2. **Get Profile**

- **Endpoint**: `/api/get-profile`
- **Method**: `GET`
- **Header**:

  ```json
    {
      "Authorization": "Bearer <auth-token>"
    }

- **Response**:

  ```json
  {
      "status": "success",
      "message": "Profile retrieved successfully",
      "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "mobile_no": "1234567890",
        "status": "active",
        "details": {
          "address_1": "123 Main St",
          "address_2": "Apt 101",
          "city": "New York",
          "state": "NY",
          "pincode": "10001"
        }
      }
  }

- **Failure**:

  ```json
     {
         "status": "error",
         "message": "Unauthenticated. Please provide a valid token."
     }


