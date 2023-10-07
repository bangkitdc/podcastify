# Podcastify - Your Daily Podcast App
Podcastify is your go-to application for daily podcasts. With a simple and intuitive interface, it allows you to listen to your favorite podcasts anytime, anywhere.

## Functionality
1. <b>Recommendation Podcasts</b>: The homepage features recommended podcasts, providing users with a curated list of popular and trending podcasts.
2. <b>Search Functionality</b>: Users can search through a vast library of podcasts to find their favorite ones or discover new ones.
3. <b>Podcast Player</b>: Each episode of the chosen podcast can be listened to directly within the app, providing a seamless listening experience.
4. <b>Admin Panel</b>: Administrators have the ability to manage podcasts, episodes, and users, ensuring the content is up-to-date and the user experience is optimized.

## Tech Stacks
Podcastify is built using the following technologies:

* <b>HTML/CSS/JS</b>: The frontend of the application is built with pure HTML, CSS, and JavaScript, ensuring a lightweight and responsive user interface.
* <b>PHP</b>: PHP is used on the backend for server-side scripting, providing robust and secure functionality.
* <b>Docker</b>: The application and its database are containerized using Docker, ensuring easy setup, deployment, and distribution.
* <b>Docker Compose</b>: Docker Compose is used to manage the application services, allowing the app and database to be run together seamlessly.

## How to Get Started
1. Clone this repository
2. Copy the `.env.example` file and rename it to `.env`:
```bash
    cp .env.example .env
```
3. Open the `.env` file and replace the placeholder values with your actual data.
4. On the root of this project, run the following commands:
```bash
    docker build -t tubes-1:latest .

    docker-compose up -d --build
```
5. To shut down the app, run
```bash
    docker-compose down
```
6. Ensure that the Docker Daemon is running

## Tasking

|              Name              |   NIM    | Client Side | Server Side |
| :----------------------------: | :------: | :---------: | :---------: |
| Muhammad Bangkit Dwi Cahyono   | 13521055 |             |             |
| Irsyad Nurwidianto Basuki      | 13521072 |             |             |
| Jimly Firdaus                  | 13521102 |             |             |

## Responsive Layouts & Lighthouse
<div align="center">
    <h1>Responsive Layouts</h1>
    <img src="readme/responsive/login/laptop.png" width=350>
    <img src="readme/responsive/login/tablet.png" width=250>
    <img src="readme/responsive/login/mobile.png" width=150>
    <p align="center"><em>Login Page</em></p>
    </br>
    <img src="readme/responsive/register/laptop.png" width=350>
    <img src="readme/responsive/register/tablet.png" width=250>
    <img src="readme/responsive/register/mobile.png" width=150>
    <p align="center"><em>Sign Up Page</em></p>
    <br/>
    <img src="readme/responsive/home/laptop.png" width=350>
    <img src="readme/responsive/home/tablet.png" width=250>
    <img src="readme/responsive/home/mobile.png" width=150>
    <p align="center"><em>Home Page</em></p>
    <br/>
    <img src="readme/responsive/profile/laptop.png" width=350>
    <img src="readme/responsive/profile/tablet.png" width=250>
    <img src="readme/responsive/profile/mobile.png" width=150>
    <img src="readme/responsive/modals/laptop.png" width=350>
    <img src="readme/responsive/modals/tablet.png" width=250>
    <img src="readme/responsive/modals/mobile.png" width=150>
    <p align="center"><em>Profile Page</em></p>
    <br/>
    <img src="readme/responsive/user/laptop.png" width=350>
    <img src="readme/responsive/user/tablet.png" width=250>
    <img src="readme/responsive/user/mobile.png" width=150>
    <p align="center"><em>User List Page</em></p>
    <br/>
    <img src="readme/responsive/podcast/laptop_main.png" width=350>
    <img src="readme/responsive/podcast/tablet_main.png" width=250>
    <img src="readme/responsive/podcast/mobile_main.png" width=150>
    <img src="readme/responsive/podcast/laptop_detail.png" width=350>
    <img src="readme/responsive/podcast/tablet_detail.png" width=250>
    <img src="readme/responsive/podcast/mobile_detail.png" width=150>
    <img src="readme/responsive/podcast/laptop_add.png" width=350>
    <img src="readme/responsive/podcast/tablet_add.png" width=250>
    <img src="readme/responsive/podcast/mobile_add.png" width=150>
    <img src="readme/responsive/podcast/laptop_edit.png" width=350>
    <img src="readme/responsive/podcast/tablet_edit.png" width=250>
    <img src="readme/responsive/podcast/mobile_edit.png" width=150>
    <p align="center"><em>Podcast Page</em></p>
    <br/>
    <img src="readme/responsive/episode/laptop_list.png" width=350>
    <img src="readme/responsive/episode/ipad_list.png" width=250>
    <img src="readme/responsive/episode/iphone_list.png" width=150>
    <img src="readme/responsive/episode/laptop_detail.png" width=350>
    <img src="readme/responsive/episode/ipad_detail.png" width=250>
    <img src="readme/responsive/episode/iphone_detail.png" width=150>
    <img src="readme/responsive/episode/laptop_add.png" width=350>
    <img src="readme/responsive/episode/ipad_add.png" width=250>
    <img src="readme/responsive/episode/iphone_add.png" width=150>
    <img src="readme/responsive/episode/laptop_edit.png" width=350>
    <img src="readme/responsive/episode/ipad_edit.png" width=250>
    <img src="readme/responsive/episode/iphone_edit.png" width=150>
    <p align="center"><em>Episode Page</em></p>
    <br/>
    <img src="readme/responsive/error/laptop.png" width=350>
    <img src="readme/responsive/error/tablet.png" width=250>
    <img src="readme/responsive/error/mobile.png" width=150>
    <p align="center"><em>Error Page</em></p>
    <br/>
    <h1>Lighthouse</h1>
    <img src="readme/lighthouse/login/login.jpg" width=350>
    <p align="center"><em>Login Page</em></p>
    <br/>
    <img src="readme/lighthouse/register/register.jpg" width=350>
    <p align="center"><em>Sign Up Page</em></p>
    <br/>
    <img src="readme/lighthouse/home/home.png" width=350>
    <p align="center"><em>Home Page</em></p>
    <br/>
    <img src="readme/lighthouse/profile/profile.jpg" width=350>
    <p align="center"><em>Profile Page</em></p>
    <br/>
    <img src="readme/lighthouse/user/user.jpg" width=350>
    <p align="center"><em>User List Page</em></p>
    <br/>
    <img src="readme/lighthouse/podcast/podcast_main.png" width=350>
    <img src="readme/lighthouse/podcast/podcast_detail.png" width=350>
    <img src="readme/lighthouse/podcast/podcast_edit.png" width=350>
    <img src="readme/lighthouse/podcast/podcast_add.png" width=350>
    <p align="center"><em>Podcast Page</em></p>
    <br/>
    <img src="readme/lighthouse/episode/episode_add.png" width=350>
    <img src="readme/lighthouse/episode/episode_detail.png" width=350>
    <img src="readme/lighthouse/episode/episode_edit.png" width=350>
    <img src="readme/lighthouse/episode/episode_list.png" width=350>
    <p align="center"><em>Episode Page</em></p>
    <br/>
    <img src="readme/lighthouse/error/error.jpg" width=350>
    <p align="center"><em>Error Page</em></p>
    <br/>
</b>
</div>
