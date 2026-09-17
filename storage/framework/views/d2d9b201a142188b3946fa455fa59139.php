<!DOCTYPE html>
<html>
<head>
    <title>My Movies List</title>
</head>
<body>
    <h1>My Movies List</h1>
    <p>Prepared by: Xavier A. Villegas</p>
 
    <table border="1" cellpadding="8">
        <tr>
            <th>Title</th>
            <th>Year</th>
        </tr>
 
        <?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($movie['title']); ?></td>
                <td><?php echo e($movie['year']); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\clinicsys-portal\resources\views/movies/index.blade.php ENDPATH**/ ?>