<!DOCTYPE html>
<html>
<head>
    <title>My Products List</title>
</head>
<body>
    <h1>My Products List</h1>
    <p>Prepared by: James Franco A. Gonzales</p>
 
    <table border="1" cellpadding="8">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>
 
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($product['name']); ?></td>
                <td><?php echo e($product['price']); ?></td>
                <td><?php echo e($product['stock']); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\clinicsys-portal\resources\views/products/index.blade.php ENDPATH**/ ?>