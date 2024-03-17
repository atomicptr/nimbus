# nimbus

A multi-project headless blog system made for projects like Sveltekit.

## Installation

First run the application using Docker:

Note: You have to provide an **APP\_KEY**

```sh
$ docker run --rm -e APP_KEY=... -p 8000:8000 -v mydata_dir:/app/data gcr.io/atomicptr/nimbus:latest

# next use docker ps to find this container id
$ docker ps
CONTAINER ID      IMAGE           COMMAND                  CREATED         STATUS                   PORTS      NAMES
MY_CONTAINER_ID   nimbus:latest   "docker-php-entrypoi…"   2 minutes ago   Up 2 minutes (healthy)   ........   .........

# next we apply the migrations for the database
$ docker exec -it MY_CONTAINER_ID php artisan migrate

# next we run tinker to create our admin account
$ docker exec -it MY_CONTAINER_ID php artisan tinker
> $user = new App\Models\User;
> $user->email = 'admin@example.com';
> $user->name = "Admin Adminsson";
> $user->password = Hash::make('password');
> $user->save();
```

Now you can open the site at http://localhost:8000/admin and log in, have fun!

**TODO**: Create an easier setup process

## Usage

1. Create a new blog
2. Create a new API Key and copy it
3. Create a post (that is published)
4. Look at **/admin/blogs/{blogId}/posts?api_key={apiKey}** which should list your newly created blog post
5. Check out other API end points (api_key has to be present)
    - /admin/blogs/{blogId}/posts/{postId}
    - /admin/blogs/{blogId}/series
    - /admin/blogs/{blogId}/series/{postSeriesId}
    - /admin/blogs/{blogId}/tags
    - /admin/blogs/{blogId}/tags/{tagId}

## License

[![](https://www.gnu.org/graphics/agplv3-155x51.png)](<https://tldrlegal.com/license/gnu-affero-general-public-license-v3-(agpl-3.0)>)
