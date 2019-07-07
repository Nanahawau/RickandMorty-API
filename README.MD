# Rick and Morty - <small>CODING CHALLENGE</small>

This is an API that restructures the response of an external API providing you with list of episodes of the Rick and Morty show, their comment counts, character list and comments attached to an episode.

## Development Stack
This project was built on **LAMP** (Linux + Apache + MYSQL + PHP). Laravel; The PHP framework was used.

Dependencies were managed with Composer as recommended by the Laravel documentation. For further information on Lumen, visit https://laravel.com/5.8/docs

## Basic Local Setup
Follow the procedures listed below to setup the project locally:

**NB:  Apache, Mysql, PHP7.2+ and Composer all have to be installed**

* Clone the project
* Run ``composer install`` to install all dependencies
* Make a copy of .env.example to .env and set your environment variables
* Create a database and connect the application to it via the .env file
* Run ``php artisan migrate`` to create all needed tables
* Run ``php artisan db:seed`` to populate the tables with dummy data
* Run ``php artisan serve`` to make the API accessible.


### Available Methods
* GET - Fetch records
* POST - Create records
* PUT - Update specified records
* DELETE - Delete specified records

### Custom Status Codes
* 200 - Action carried out successfully
* 400 - Bad request (An error caused by you)
* 404 - Resource not found
* 500 - You did everything right, but an error occurred (contact support)


#### EPISODES
#
**GET all episodes and comment count**
```
http://127.0.0.1:8000/api/episodes
```

Fetches all episodes with their comment counts.

**Required**
<pre>
Page number is required to move to the next page. i.e
http://127.0.0.1:8000/api/episode?page=2

</pre>

**Response**
````json
{
    "status": 200,
    "data": [
    {
    "id": 1,
    "name": "Pilot",
    "comment_count": 3
},
{
    "id": 2,
    "name": "Lawnmower Dog",
    "comment_count": 1
},
{
    "id": 3,
    "name": "Anatomy Park",
    "comment_count": 4
}
]
}

````

_**GET  a specific episode**_
```
http://127.0.0.1:8000/api/episodes/{episode}
```

Fetches a specific episode with their details.

**Response**
````json
{
    "status": 200,
    "data": {
        "id": 2,
        "name": "Lawnmower Dog",
        "air_date": "December 9, 2013",
        "episode": "S01E02"
    }
}
````

_**GET a specific episode**_

```
http://127.0.0.1:8000/api/episodes/{episode}/comments
```

Fetches comments of a specified episode.


**Response**
````json
{
    "status": 200,
    "data": [
    {
    "id": 59,
    "episode_id": 4,
    "comment": "RABBIT' engraved upon it. She went in without knocking, and     hurried upstairs, in great fear lest she should meet the real Mary        Ann, and be turned out of the window, I only wish they COULD! I'm         sure."
}
]
}
````

_**Get character list for an episode**_

```
http://127.0.0.1:8000/api/episodes/{episode}/characters
```
Get the character list for an episode

### Required Parameters
*filterby - which is the gender parameter,
*keyword - which can be either male or female,
*sortby - name, gender, species parameter,
*order - either asc or desc


**Response**

```json
{
    "status": 200,
    "data": [
        {
            "id": 1,
            "name": "Rick Sanchez",
            "status": "Alive",
            "species": "Human",
            "gender": "Male"
        },
        {
            "id": 2,
            "name": "Morty Smith",
            "status": "Alive",
            "species": "Human",
            "gender": "Male"
        },
        {
            "id": 35,
            "name": "Bepisian",
            "status": "Alive",
            "species": "Alien",
            "gender": "unknown"
        },
        {
            "id": 38,
            "name": "Beth Smith",
            "status": "Alive",
            "species": "Human",
            "gender": "Female"
        },
        {
            "id": 62,
            "name": "Canklanker Thom",
            "status": "Dead",
            "species": "Alien",
            "gender": "Male"
        },
        {
            "id": 92,
            "name": "Davin",
            "status": "Dead",
            "species": "Human",
            "gender": "Male"
        },
        {
            "id": 127,
            "name": "Frank Palicky",
            "status": "Dead",
            "species": "Human",
            "gender": "Male"
        },
        {
            "id": 144,
            "name": "Glenn",
            "status": "Dead",
            "species": "Alien",
            "gender": "Male"
        },
        {
            "id": 158,
            "name": "Hookah Alien",
            "status": "Alive",
            "species": "Alien",
            "gender": "unknown"
        },
        {
            "id": 175,
            "name": "Jerry Smith",
            "status": "Alive",
            "species": "Human",
            "gender": "Male"
        },
        {
            "id": 179,
            "name": "Jessica",
            "status": "Alive",
            "species": "Cronenberg",
            "gender": "Female"
        },
        {
            "id": 181,
            "name": "Jessica's Friend",
            "status": "Alive",
            "species": "Human",
            "gender": "Female"
        },
        {
            "id": 239,
            "name": "Mr. Goldenfold",
            "status": "Alive",
            "species": "Cronenberg",
            "gender": "Male"
        },
        {
            "id": 249,
            "name": "Mrs. Sanchez",
            "status": "unknown",
            "species": "Human",
            "gender": "Female"
        },
        {
            "id": 271,
            "name": "Principal Vagina",
            "status": "Alive",
            "species": "Cronenberg",
            "gender": "Male"
        },
        {
            "id": 338,
            "name": "Summer Smith",
            "status": "Alive",
            "species": "Human",
            "gender": "Female"
        },
        {
            "id": 394,
            "name": "Davin",
            "status": "Dead",
            "species": "Cronenberg",
            "gender": "Male"
        },
        {
            "id": 395,
            "name": "Greebybobe",
            "status": "Alive",
            "species": "Alien",
            "gender": "unknown"
        },
        {
            "id": 435,
            "name": "Pripudlian",
            "status": "Alive",
            "species": "Alien",
            "gender": "unknown"
        }
    ]
}

```


_**POST create comment**_

```
http://127.0.0.1:8000/api/episode/{episode_id}/comments
```
Create a new comment for an episode. 

**Request**
```json
{
  "comment" : "This is the best episode of Rick and Morty"
}
````

**Response**
````json
{
    "status": 200,
    "message": {
        "episode_id": "101",
        "comment": "This is the best episode of Rick and Morty",
        "updated_at": "2019-07-06 20:51:41",
        "created_at": "2019-07-06 20:51:41",
        "id": 103
    }
}
````

_**PUT update comment**_

```
http://127.0.0.1:8000/api/episodes/comments/{comment}
```

Update a specific comment for an episode.

**Request**
```
{
    "comment" : "This is my favorite Rick and Morty Episode"
}
```


**Response**

```json

{
    "status": 200,
    "message": "Comment Successfully Updated",
    "data": {
        "id": 101,
        "episode_id": 18,
        "comment": "This is my favorite Rick and Morty Episode",
        "created_at": "2019-07-05 17:58:05",
        "updated_at": "2019-07-06 20:58:36"
    }
}

```

_**DELETE a comment**_

```
http://127.0.0.1:8000/api/episodes/comments/{comment}
```
This endpoint deletes a comment permanently

**Response**
```json
{
    "status": 200,
    "message": "Comment successfully deleted"
}
```

#
## STAGING
**Base URL:** https://rickandmorty-api.herokuapp.com
