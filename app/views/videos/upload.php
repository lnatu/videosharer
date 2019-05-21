<?php require_once "../app/views/layouts/header.php"; ?>
<section class="upload">
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="upload__box">
                    <form action="<?php echo URL_ROOT; ?>uploads" method="POST" enctype="multipart/form-data"
                        id="uploadForm">
                        <div class="form-group upload__box--group">
                            <label for='file' class='upload__box--title'>Choose video</label>
                            <input type='file' id='file' name='file' class='form-control-file upload__box--file'>
                        </div>
                        <div class="form-group upload__box--group">
                            <label for='title' class='upload__box--title'>Video title</label>
                            <input type='text' id='title' name='title' class='form-control upload__box--input'>
                        </div>
                        <div class="form-group upload__box--group">
                            <label for='description' class='upload__box--title'>Description</label>
                            <textarea name="description" id="description" rows="5"
                                class="form-control upload__box--input"></textarea>
                        </div>
                        <div class="form-group upload__box--group">
                            <label for='status' class='upload__box--title'>Status</label>
                            <select name="status" id="status" class="form-control upload__box--options">
                                <option value="0">Private</option>
                                <option value="0">Public</option>
                            </select>
                        </div>
                        <div class="form-group upload__box--group">
                            <label for='category' class='upload__box--title'>Category</label>
                            <select name="category" id="category" class="form-control upload__box--options">
                                <?php
                                    $categories = $data['categories'];
                                    foreach($categories as $category) :
                                ?>
                                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group upload__box--group">
                            <input type='submit' name='upload' class='btn btn-primary upload__box--btn' value="UPLOAD">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">PROCESSING REQUEST PLEASE WAIT</h5>
                </div>
                <div class="modal-body text-center">
                    <img src="assets/img/loading/pacman.gif" alt="loading">
                </div>
            </div>
        </div>
    </div>
    <?php flash('upload_feedback') ;?>
</section>
<?php require_once "../app/views/layouts/footer.php"; ?>