<?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <article class="search-page-card" id="user<?php echo e($user->id); ?>">
        <a href="../profile/<?php echo e($user->id); ?>">
            <h2 class="user-username search-page-card-user"> <?php echo e($user->name); ?></h2>
        </a>
        <h3 class="search-user-card-username">&#64;<?php echo e($user->username); ?></h3>
        </div>
    </article>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <h2 class="no_results">No results found</h2>
<?php endif; ?>
<?php /**PATH /Users/eamachado/lbaw2372/resources/views/partials/searchUser.blade.php ENDPATH**/ ?>