<?php $__env->startSection('title', 'user'); ?>

<?php $__env->startSection('content'); ?>

<div class="userinfo" data-id="<?php echo e($user->id); ?>">

    <span class="dot"></span>
    <div class="user">
    <p><a href="/profile/<?php echo e($user->id); ?>"><?php echo e($user->name); ?></a></p>
    </div>

    <div class="username">
        <p>@ <?php echo e($user->username); ?></p>
    </div>

    <?php if(Auth::check()): ?>
    <?php if($user->id == Auth::User()->id): ?> 

    <a class="button" href="/profile/<?php echo e($user->id); ?>/editUser">Edit Profile</a>
    <a class="button" href="/logout" class="delete">&#10761;Delete Profile</a>

    <?php else: ?>
    <?php if(!$isFollowing): ?>
        <form method="POST" action="/profile/follow/<?php echo e($user->id); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit">Follow</button>
         </form>
    <?php else: ?>
        <form method="POST" action="/profile/unfollow/<?php echo e($user->id); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit">Unfollow</button>
    </form>
    <?php endif; ?>
    <?php endif; ?>
     <?php endif; ?>
    <a class="button" href="/homepage">Back to home page</a>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/eamachado/lbaw2372/resources/views/pages/user.blade.php ENDPATH**/ ?>