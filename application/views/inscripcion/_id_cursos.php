<div class="card card-custom">
    <div class="card-body form-group pb-0">
        <label for="id"> Elija el curso <span class="text-danger">(*)</span></label> <br>
        <select name="id" id="id" class="form-control" required>
            <option value=""> Elige </option>
            <?php
            foreach ($cursos as  $curso) {
                echo "<option value='" . $curso->id . "'>" . $curso->fullname . "</option>";
            }
            ?>
        </select>
    </div>
</div>