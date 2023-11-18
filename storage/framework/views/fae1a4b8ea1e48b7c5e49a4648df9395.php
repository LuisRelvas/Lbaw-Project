<?php $__env->startSection('title', 'user'); ?>

<?php $__env->startSection('content'); ?>


<article class="user" data-id="<?php echo e($user->id); ?>">

    <header>
    <h2><a href="/profile/<?php echo e($user->id); ?>"><?php echo e($user->name); ?></a></h2>
    </header>
    <h1><?php echo e($user->username); ?></h1>
    <h3><a href="/profile/<?php echo e($user->id); ?>/editUser">Edit Profile</a></h3>
    <h3><a href="/logout" class="delete">&#10761;Delete Profile</a></h3>
    <h3><a href="/homepage">Back to home page</a></h3>

</article>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/eamachado/lbaw2372/resources/views/pages/user.blade.php ENDPATH**/ ?>