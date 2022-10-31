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
 *     type="http",
 *     description="Use a global client_id / client_secret and your username / password combo to obtain a token",
 *     name="Password Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth",
 * )
 *
 * @OA\Get(
 *     tags={"Users"},
 *     path="/users/me",
 *     security={{"bearerAuth":{""}}},
 *     @OA\Response(response="200", description="An example resource")
 * )
 *
 * @OA\Put(
 *     tags={"Users"},
 *     path="/users/me",
 *     security={{"bearerAuth":{""}}},
 *      @OA\Parameter(
 *          name="name",
 *          description="Name and Surname",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Parameter(
 *          name="username",
 *          description="User Name",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),@OA\Parameter(
 *          name="password",
 *          description="Password",
 *          required=false,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),@OA\Parameter(
 *          name="email",
 *          description="Email",
 *          required=false,
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
 *
 * @OA\Get(
 *     tags={"Users"},
 *     path="/users/{id}",
 *     security={{"bearerAuth":{""}}},
 *      @OA\Parameter(
 *          name="id",
 *          description="Get user by user Id.",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Response(response="200", description="An example resource")
 * )
 *
 * @OA\Get(
 *     tags={"Users"},
 *     path="/users/@{username}",
 *     security={{"bearerAuth":{""}}},
 *      @OA\Parameter(
 *          name="username",
 *          description="Find user by username. Must use like '@<-username->'",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Response(response="200", description="An example resource")
 * )
 *
 * @OA\Get(
 *     tags={"Search"},
 *     path="/search",
 *     security={{"bearerAuth":{""}}},
 *      @OA\Parameter(
 *          name="searchKey",
 *          description="Find users by key.",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\Response(response="200", description="An example resource")
 * )
 *
 * @OA\Post(
 *     tags={"Auth"},
 *     path="/register",
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
 *
 * @OA\Post(
 *     tags={"Auth"},
 *     path="/login",
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
 *
 * @OA\Post(
 *     tags={"Auth"},
 *     path="/users/logout",
 *     security={{"bearerAuth":{""}}},
 *     @OA\Response(response="200", description="An example resource")
 * )
 *
 * @OA\Get(
 *     tags={"Messages"},
 *     path="/messages",
 *     description="Get all message rooms.",
 *     security={{"bearerAuth":{""}}},
 *     @OA\Response(response="200", description="An example resource")
 * )
 *
 * @OA\Post(
 *     tags={"Messages"},
 *     path="/messages/create",
 *     description="Send a message.",
 *     security={{"bearerAuth":{""}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="isGroup",
 *                     description="is this a group?",
 *                     example="false",
 *                     type="boolean"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     description="If it is a group chat name it!",
 *                     example="New Group Chat",
 *                     type="string"
 *                 ),
 *              @OA\Property(
 *                  property="to",
 *                  type="array",
 * *                @OA\Items(
 *                      type="number",
 *                      description="User Ids",
 *                      @OA\Schema(type="number")
 *                  ),
 *                  description="Group participants ids"
 *              )
 *             )
 *          )
 *     ),
 *     @OA\Response(response="200", description="An example resource")
 * )
 *
 */

class SwaggerController extends Controller
{
}
