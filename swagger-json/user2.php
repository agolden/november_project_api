{
    "apiVersion": "1.0.0",
    "swaggerVersion": "1.2",
    "basePath": "http://petstore.swagger.wordnik.com/api",
    "resourcePath": "/user",
    "produces": [
        "application/json"
    ],
    "apis": [
        {
            "path": "/user/{username}",
            "operations": [
                {
                    "method": "GET",
                    "summary": "Get user by user name",
                    "parameters": [
                        {
                            "name": "username",
                            "description": "The name that needs to be fetched. Use user1 for testing.",
                            "required": true,
                            "type": "string",
                            "paramType": "path"
                        }
                    ],
                    "responseMessages": [
                        {
                            "code": 400,
                            "message": "Invalid username supplied"
                        },
                        {
                            "code": 404,
                            "message": "User not found"
                        }
                    ]
                }
            ]
        }
    ]
  
}