# Startup Instructions

After cloning the repository, navigate to the `smartiveapp` folder and create a `.env` file using the command:

```bash
cp .env.example .env
```

Check your ID using the `id` command and enter the appropriate values in the `.env` file:

```bash
LOCAL_UID=1001
LOCAL_GID=1001
```

Run the command:

```bash
bin/up
```

This will build the Docker images and start the containers.

Create a folder to place the images for which thumbnails will be generated:

```bash
mkdir var/uploads
```

Copy images in jpg or png format to this folder.

Start the php container console using the command:

```bash
bin/dev
```

In the console, enter the command that will queue the image file for thumbnail creation:

```bash
bin/console thumbnail:create <image_file_name> <file_system|sftp>
```

The second parameter indicates where the generated thumbnail will be saved:

- `file_system` - `var/uploads/thumbnails` folder
- `sftp` - on the sftp server in the `thumbnails` folder

```bash
bin/console thumbnail:create test1.jpg sftp
bin/console thumbnail:create test2.jpg file_system
```

The command returns the id of the entity saved in the database after execution. You can check the processing status by using the command:

```bash
bin/console thumbnail:status <id>
```

```bash
bin/console thumbnail:status 2
```

To check if the thumbnail has been uploaded to the sftp server, enter the following command in the php container console:

```bash
sftp smartiveapp@sftp
```

password: `viswocrebr`

The uploaded files should be in the `thumbnails` folder.

After exiting the container console, you can down the containers using the command:

```bash
bin/down
```
