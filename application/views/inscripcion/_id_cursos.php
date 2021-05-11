<br>
<div class="card card-custom">
    <div class="card-body form-group pb-0">
        <label for="id"> Elija el curso <span class="text-danger">(*)</span></label> <br>
        <select name="id" id="id" class="form-control" required>
            <option value=""> Elige </option>
            <?php
            foreach ($cursos as  $curso) {
                echo "<option value='" . base64_encode($this->encryption->encrypt($curso->id_course_moodle)) . "'>" . $curso->fullname . "</option>";
            }
            ?>
        </select>
    </div>
</div>