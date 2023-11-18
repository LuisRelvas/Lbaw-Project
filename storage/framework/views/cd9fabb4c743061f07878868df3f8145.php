<?php $__env->startSection('content'); ?>
    <main class="flex-container">
        <div class="sidebar">
            <!-- Sidebar content -->
            <a href="#">Home</a>
            <a href=" <?php echo e(url('/search')); ?>">Explore</a>
            <a href = "<?php echo e(url('/profile/'.Auth::user()->id)); ?>">Profile</a>
            <a href="#">Notifications</a>
            <a href="#">Settings</a>
            <!-- Add more links as needed -->
        </div>

        <div class="content">
            <input type="text" id="search">
            <div id="results-users"></div>
            <div class="card-header"><?php echo e(__('Spaces')); ?></div>

            <div class="card-body">
                <ul>
                    <?php $__currentLoopData = $spaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $space): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="/space/<?php echo e($space->id); ?>"><?php echo e($space->content); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="card-header"><?php echo e(__('My Spaces')); ?></div>
            <div class="card-body">
                <ul>
                    <?php $__currentLoopData = $mines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="/space/<?php echo e($mine->id); ?>"><?php echo e($mine->content); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php echo $__env->make('partials.addSpace', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/eamachado/lbaw2372/resources/views/pages/home.blade.php ENDPATH**/ ?>