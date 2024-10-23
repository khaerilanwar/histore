import urllib.request
import os

path_folder = 'storage\\app\\public\\images'

name_file = f'category5.jpg'
save_path = os.path.join(path_folder, name_file)
urllib.request.urlretrieve('https://picsum.photos/400', save_path)
print(f"Saved {name_file}")

# for i in range(10):
#     name_file = f'category{i}.jpg'
#     save_path = os.path.join(path_folder, name_file)
#     urllib.request.urlretrieve('https://picsum.photos/400', save_path)
#     print(f"Saved {name_file}")

# for j in range(25):
#     name_image = f'image{j}.jpg'
#     save_image = os.path.join(path_folder, name_image)
#     urllib.request.urlretrieve('https://picsum.photos/600/400', save_image)
#     print(f"Saved {name_image}")
