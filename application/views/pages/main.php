<form action="/main/upload" method="post" enctype="multipart/form-data">
        <input type="file" name="userFile">
        <input type="hidden" name="filename" value="<?=$filename?>">
        <button value="<?=$upload?>" name="upload" type="submit">Submit</button>
    </form>
    