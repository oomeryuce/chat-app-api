<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      version="1.0",
 *      title="Chat App Api",
 *      description="UACS Graduation Web Chat App - Api documentation",
 *      x={
 *          "logo": {
 *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
 *          }
 *      },
 *      @OA\Contact(
 *          email="omeryuce1907@gmail.com"
 *      ),
 *      @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     type="oauth2",
 *     description="Use a global client_id / client_secret and your username / password combo to obtain a token",
 *     name="Password Based",
 *     in="header",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 *     @OA\Flow(
 *         flow="password",
 *         tokenUrl="/oauth/token",
 *         scopes={}
 *     )
 * )
 *
 * @OA\Get(
 *     tags={"Users"},
 *     path="/users/me",
 *     security={{"bearerAuth":{""}}},
 *     @OA\Response(response="200", description="An example resource")
 * )
 * @OA\Post(
 *     tags={"Users"},
 *     path="/users/register",
 *      @OA\Parameter(
 *          name="name",
 *          description="Name and Surname",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="username",
 *          description="User Name",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),@OA\Parameter(
 *          name="password",
 *          description="Password",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),@OA\Parameter(
 *          name="email",
 *          description="Email",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),@OA\Parameter(
 *          name="bio",
 *          description="Users brief description",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),@OA\Parameter(
 *          name="avatar",
 *          description="User avatar",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="file"
 *          )
 *      ),
 *     @OA\Response(response="200", description="An example resource")
 * )
 * @OA\Post(
 *     tags={"Users"},
 *     path="/users/login",
 *     description="You can login with email or username.",
 *     @OA\Parameter(
 *          name="username",
 *          description="Username",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="email",
 *          description="Email",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="password",
 *          description="Password",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Response(response="200", description="An example resource")
 * )
 * @OA\Post(
 *     tags={"Users"},
 *     path="/users/logout",
 *     @OA\Response(response="200", description="An example resource")
 * )
 *
 */

class SwaggerController extends Controller
{
}
