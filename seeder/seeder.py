import mysql.connector
from fakerData import generateFakeUser, generateFakePodcast, generateFakeEpisode
import random

class DatabaseSeeder:
  def __init__(self, connection):
    self.connection = connection

  def seedUsers(self, num):
    cursor = self.connection.cursor()

    for _ in range(num):      
      while True:
        fakeUser = generateFakeUser()
        try:
          cursor.execute("""
              INSERT INTO users (email, username, password, first_name, last_name, status, role_id)
              VALUES (%s, %s, %s, %s, %s, %s, %s)
            """, (
            fakeUser['email'],
            fakeUser['username'],
            fakeUser['password'],
            fakeUser['first_name'],
            fakeUser['last_name'],
            fakeUser['status'],
            fakeUser['role_id']
          ))
          break
        except mysql.connector.errors.IntegrityError as e:
          continue

    self.connection.commit()
    cursor.close()
    
    print("Users seeds done!")
  
  def seedPodcasts(self, num):
    cursor = self.connection.cursor()

    for _ in range(num):      
      while True:
        fakePodcast = generateFakePodcast()
        try:
          cursor.execute("""
            INSERT INTO podcasts (title, description, creator_name, category_id)
            VALUES (%s, %s, %s, %s)
          """, (
            fakePodcast['title'],
            fakePodcast['description'],
            fakePodcast['creator_name'],
            fakePodcast['category_id']
          ))
          break
        except mysql.connector.errors.IntegrityError as e:
          continue

    self.connection.commit()
    cursor.close()
    
    print("Podcasts seeds done!")
    
  def seedEpisodes(self, num):
    cursor = self.connection.cursor()

    cursor.execute("SELECT podcast_id FROM podcasts")
    podcast_ids = [row[0] for row in cursor.fetchall()]

    for _ in range(num):
      podcast_id = random.choice(podcast_ids)
                  
      while True:
        fakeEpisode = generateFakeEpisode(podcast_id)
        try:
          cursor.execute("""
            INSERT INTO episodes (podcast_id, category_id, title, description, duration, audio_url)
            VALUES (%s, %s, %s, %s, %s, %s)
          """, (
            fakeEpisode['podcast_id'],
            fakeEpisode['category_id'],
            fakeEpisode['title'],
            fakeEpisode['description'],
            fakeEpisode['duration'],
            '',
          ))
          break
        except mysql.connector.errors.IntegrityError as e:
          continue

    self.connection.commit()
    cursor.close()
    
    print("Episodes seeds done!")

# Replace with your actual database connection details
db_connection = mysql.connector.connect(
  host='127.0.0.1',
  user='podcastify',
  port='3307',
  password='podcastify',
  database='podcastify'
)

# Instantiate the seeder
seeder = DatabaseSeeder(db_connection)

seeder.seedUsers(10000)
seeder.seedPodcasts(10000)
seeder.seedEpisodes(10000)

# Close the connection
db_connection.close()
