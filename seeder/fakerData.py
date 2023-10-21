from faker import Faker
import random

fake = Faker()

def generateFakeUser():
  return {
    'email': fake.email(),
    'username': fake.user_name(),
    'password': '$2y$10$zB1TCZSYw3NXIXuu5tu.bO5Pnc7jaZSu/TC62aQ6I42sYM1bD4HJa',
    'first_name': fake.first_name(),
    'last_name': fake.last_name(),
    'status': fake.random_element(elements=(0, 1)),
    'role_id': 2
  }

def generateFakePodcast():
  return {
    'title': fake.catch_phrase(),
    'description': fake.paragraph(),
    'creator_name': fake.name(),
    'category_id': random.randint(1, 5)
  }

def generateFakeEpisode(podcastId):
  return {
    'podcast_id': podcastId,
    'category_id': random.randint(1, 5),
    'title': fake.catch_phrase(),
    'description': fake.paragraph(),
    'duration': random.randint(1, 100) * 60
  }