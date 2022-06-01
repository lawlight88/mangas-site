<p align="center">
    <img src="![logo](https://user-images.githubusercontent.com/101893955/171506198-cbf87dc5-8365-4e13-9fec-d052bb57c883.png)">
</p>

<h1 align="center">Mangas Site</h1>

A site where a user can read, add mangas to favorites, comment
on chapters and create a scanlator, which can upload, edit and remove
chapters.

Table of Contents
=================

* [Roles](#roles)
    * [User](#user)
    * [Scanlator Helper (SH)](#scanlator-helper)
    * [Scanlator Leader (SL)](#scanlator-leader)
    * [Admin](#admin)
* [Chapters Upload](#chapters-upload)
* [API](#api)
    * [Actions for Unregistered Users](#api-unregistered-users)
        * [Get Mangas](#get-mangas)
        * [Get Chapters](#get-chapters)
        * [Get Chapter's Comments](#get-chapters)
        * [Search Manga](#search-manga)
        * [Get User Comments](#get-user-comments)
    * [Authentication](#api-authentication)
        * [Login](#api-login)
        * [Logout](#api-logout)
    * [Actions for Registered Users](#api-registered-users)
        * [Get User Favorites](#api-user-favorites)
        * [Create Comment](#api-create-comment)
        * [Update Comment](#api-update-comment)
        * [Delete Comment](#api-delete-comment)
        * [Get Temp Files](#api-get-temp-files)

# Roles

Each user has a role that defines authorization for each action.

## User

A typical registered user can:

- Comment on mangas' chapters.
- Favorite a manga.
- Create a Scanlator.
- Receive an invite from Scanlator.

While an unregistered user can only read mangas.

## Scanlator Helper (SH)

This is a user who accepted an invite from a SL and now can
perform basic actions on Scanlator:

- Upload, edit and delete mangas' chapters.

## Scanlator Leader (SL)

An user that created a Scanlator or one that the lead have been
passed. They can do the same as a SH in addition to:

- Request mangas from to work on.
- Edit infos about mangas from Scanlator and remove from Scan (doesn't delete).
- Edit Scanlator's members' role.
- Invite other users to the Scan.
- Pass the lead to other member.
- Edit Scan description and image (cannot change name).
- Delete the Scan.

## Admin

An user that has been set to admin can do everything a SL can (except
for invites) and:

- Create and delete mangas.
- Accept or refuse requests from Scanlators.
- Delete users' comments.

# Chapters Upload

Each chapter can have a have a min of 2 pages and the max of 100 in
jpg, png or pdf format.

The first uploaded images are stored on the 'temp' disk on the manga's
folder. Images stored on 'temp' disk are only visible to
Scanlator's members and admins.

Then these images are shown on preview page where the user can
edit the orders, add more or delete them.

The user can only upload them when exists at least 2 images as well.

# API

This API has basic actions for unregistered users and registered ones.
And only response in JSON.

## Actions for Unregistered Users

All of this actions are performed through HTTP GET method and
prefixed by `/api`.

### Get Mangas

Request: `/mangas/{id_manga}`

Response:

```
{
    "id": 214218,
    "name": "Aliquid ipsum officia",
    "author": "Felix Cummings",
    "desc": "Nostrum dolores quia nisi. Alias illum asperiores illo reiciendis. Nam porro velit ut voluptatem sequi.",
    "ongoing": true,
    "cover": "storage/mangas/214218/cover.png",
    "id_scanlator": 21,
    "last_chapter_uploaded_at": "2022-05-31 21:19:49",
    "created_at": "2022-05-31T21:19:47.000000Z",
    "updated_at": "2022-06-01T18:37:05.000000Z",
    "chapters_count": 4
}
```

If `id_manga` is not provided, the response will be in format of ``LengthAwarePaginator``
paginating 10 mangas ordered by views on last seven days:

```
{
    "current_page": 1,
    "data": [
        {
            "id": 214218,
            "name": "Aliquid ipsum officia",
            "author": "Felix Cummings",
            "desc": "Nostrum dolores quia nisi. Alias illum asperiores illo reiciendis. Nam porro velit ut voluptatem sequi.",
            "ongoing": true,
            "cover": "storage/mangas/214218/cover.png",
            "id_scanlator": 21,
            "last_chapter_uploaded_at": "2022-05-31 21:19:49",
            "created_at": "2022-05-31T21:19:47.000000Z",
            "updated_at": "2022-06-01T18:37:05.000000Z",
            "chapters_count": 4,
            "views_count": 2
        },
        {
            "id": 154977,
            "name": "Et modi maiores",
            "author": "Hollis Kohler",
            "desc": "Earum eum adipisci itaque sit aspernatur porro. Odit quis dolores quaerat ut velit nemo ab. Debitis sed quasi vero qui. Provident error qui beatae possimus suscipit omnis ea. Sed at voluptatem vitae voluptatem.",
            "ongoing": true,
            "cover": "storage/mangas/154977/cover.png",
            "id_scanlator": null,
            "last_chapter_uploaded_at": "2022-05-31 21:20:18",
            "created_at": "2022-05-31T21:20:15.000000Z",
            "updated_at": "2022-05-31T21:20:18.000000Z",
            "chapters_count": 5,
            "views_count": 0
        },
        ...
    ],
    "first_page_url": "http://app/api/mangas?page=1",
    "from": 1,
    "last_page": 5,
    "last_page_url": "http://app/api/mangas?page=5",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://app/api/mangas?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": "http://app/api/mangas?page=2",
            "label": "2",
            "active": false
        },
        {
            "url": "http://app/api/mangas?page=3",
            "label": "3",
            "active": false
        },
        {
            "url": "http://app/api/mangas?page=4",
            "label": "4",
            "active": false
        },
        {
            "url": "http://app/api/mangas?page=5",
            "label": "5",
            "active": false
        },
        {
            "url": "http://app/api/mangas?page=2",
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": "http://app/api/mangas?page=2",
    "path": "http://app/api/mangas",
    "per_page": 10,
    "prev_page_url": null,
    "to": 10,
    "total": 49
}
```

### Get Chapters

Request: `/mangas/{id_manga}/chapters`

Response paginating 10 chapters:
```
{
    "current_page": 1,
    "data": [
        {
            "id_manga": 214218,
            "id": 64,
            "order": 1,
            "name": "Chapter 1",
            "created_at": "2022-05-31T21:19:47.000000Z",
            "updated_at": "2022-05-31T21:19:47.000000Z",
            "pages": [
                {
                    "id_chapter": 64,
                    "id": 465,
                    "order": 1,
                    "path": "storage/mangas/214218/Chapter_1/1.png"
                },
                {
                    "id_chapter": 64,
                    "id": 466,
                    "order": 2,
                    "path": "storage/mangas/214218/Chapter_1/2.png"
                }
                ...
            ]
        },
        {
            "id_manga": 214218,
            "id": 65,
            "order": 2,
            "name": "Chapter 2",
            "created_at": "2022-05-31T21:19:48.000000Z",
            "updated_at": "2022-05-31T21:19:48.000000Z",
            "pages": [
                ...
            ]
        },
        ...
    ],
    ...
}
```

### Get Chapter's Comments

Request: ``/mangas/{id_manga}/chapters/{chapter_order}/comments``

Response:
```
[
    {
        "id": 1,
        "id_user": 3,
        "id_chapter": 64,
        "body": "nice",
        "created_at": "2022-06-01T20:09:05.000000Z",
        "updated_at": "2022-06-01T20:09:05.000000Z"
    },
    {
        "id": 2,
        "id_user": 1,
        "id_chapter": 64,
        "body": "awesome",
        "created_at": "2022-06-01T20:09:39.000000Z",
        "updated_at": "2022-06-01T20:09:39.000000Z"
    }
]
```

### Search Manga

Request: `/mangas/search/{search}`

Response paginating 10 mangas ordered by views:

```
{
    "current_page": 1,
    "data": [
        {
            "id": 527040,
            "name": "Ducimus aut expedita",
            "author": "Lennie Erdman",
            "desc": "Sed quidem aut velit. Soluta enim saepe nam dolore. Et quis sunt inventore et laudantium omnis. Minus aut debitis et error inventore commodi.",
            "ongoing": true,
            "cover": "storage/mangas/527040/cover.png",
            "id_scanlator": null,
            "last_chapter_uploaded_at": "2022-05-31 21:19:03",
            "created_at": "2022-05-31T21:19:01.000000Z",
            "updated_at": "2022-05-31T21:19:03.000000Z",
            "views_count": 0
        },
        ...
    ],
   ...
}
```

### Get User Comments

Request: `/user/{id_user}/comments`

Response paginating 10 comments:

```
{
    "comments": {
        "current_page": 1,
        "data": [
            {
                "id": 2,
                "id_user": 1,
                "id_chapter": 64,
                "body": "awesome",
                "created_at": "2022-06-01T20:09:39.000000Z",
                "updated_at": "2022-06-01T20:09:39.000000Z"
            },
            ...
        ],
        ...
    }
}
```

## Authentication

You need to get use a token to be able to do the next actions. In order
to get a token you need to login and if you want to destroy the token,
need to logout.

### Login

Request: `POST /login`
```
{
    "email": "example@example.com",
    "password": "examplepass"
}
```

Response:
```
{
    "token": "1|whtNT8wc6ZcHIDSG9UyM9jfLocREbLURcI1z9afF"
}
```

### Logout


Request with the token: `DELETE /logout`

Response:
```
{
    "message": "Logged out"
}
```

## Actions for Registered Users


### Get User Favorites

Request: ``GET /user/{id_user}/favorites``

Response:
```
{
    "favorites": [
        {
            "id": 10,
            "id_user": 3,
            "id_manga": 373592
        },
        ...
    ]
}
```

If your requesting for your own favorites or if you are admin you
will get a response paginating 10 mangas, else you get only 4 mangas.

### Create Comment

Request: `POST /mangas/{id_manga}/chapters/{chapter_order}/comments`
```
{
    "body": "an example"
}
```

Response:
```
{
    "comment": {
        "id_chapter": 72,
        "id_user": 1,
        "body": "an example",
        "updated_at": "2022-06-01T21:05:33.000000Z",
        "created_at": "2022-06-01T21:05:33.000000Z",
        "id": 3
    }
}
```

### Update Comment

Request: `PUT /comments/{id_comment}`
```
{
    "body": "another example"
}
```

Response:
```
{
    "Result": "Comment successfully edited"
}
```

### Delete Comment

Request: `DELETE /comments/{id_comment}`

Response:
```
{
    "Result": "Comment was successfully deleted"
}
```

### Get Temp Files

Request: `GET /mangas/{id_manga}/temp`

Response:
```
{
    "page_1": "http://app/mgmt/p/display/214218/1",
    "page_2": "http://app/mgmt/p/display/214218/2",
    "page_3": "http://app/mgmt/p/display/214218/3",
    "page_4": "http://app/mgmt/p/display/214218/4",
    "page_5": "http://app/mgmt/p/display/214218/5",
    "page_6": "http://app/mgmt/p/display/214218/6",
    "page_7": "http://app/mgmt/p/display/214218/7"
}
```

You can only get temp files if your Scanlator is in charge of it
or if you are admin.
