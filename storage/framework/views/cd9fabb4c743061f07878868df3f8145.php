<?php $__env->startSection('content'); ?>

<main class="flex-container">
        <?php if(Auth::check()): ?>
            <div class="sidebar">
                <!-- Sidebar content -->
                <a href="#">Home</a>
                <a href="<?php echo e(url('/search')); ?>">Explore</a>
                <a href="<?php echo e(url('/profile/' . Auth::user()->id)); ?>">Profile</a>
                <a href="#">Notifications</a>
                <a href="#">Settings</a>
            </div>
        <?php else: ?>
            <div class="sidebar">
                <!-- Sidebar content -->
                <a href="<?php echo e(url('/login')); ?>">Home</a>
                <a href="<?php echo e(url('/login')); ?>">Explore</a>
                <a href="<?php echo e(url('/login')); ?>">Profile</a>
                <a href="<?php echo e(url('/login')); ?>">Notifications</a>
                <a href="<?php echo e(url('/login')); ?>">Settings</a>
            </div>
        <?php endif; ?>

        <div class="content">
        <?php if($errors->has('profile')): ?>
            <span class="error">
                <?php echo e($errors->first('profile')); ?>

            </span>
        <?php endif; ?>
        <?php if(session('success')): ?>
                <p class="success">
                    <?php echo e(session('success')); ?>

                </p>
        <?php endif; ?>
            <div class="card-header"><?php echo e(__('Public Spaces')); ?></div>
            <div class="card-body">
                <ul class="card-list">
                    <?php $__currentLoopData = $publics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $public): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="/space/<?php echo e($public->id); ?>" class="card"><?php echo e($public->content); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <?php if(Auth::check()): ?>
                <div class="card-header"><?php echo e(__('Spaces')); ?></div>

                <div class="card-body">
                    <ul class="card-list">
                        <?php $__currentLoopData = $spaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $space): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="/space/<?php echo e($space->id); ?>" class="card"><?php echo e($space->content); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div class="card-header"><?php echo e(__('My Spaces')); ?></div>
                <div class="card-body">
                    <ul class="card-list">
                        <?php $__currentLoopData = $mines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="/space/<?php echo e($mine->id); ?>" class="card"><?php echo e($mine->content); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="searchbar">
            <?php if(Auth::check()): ?>
                <?php echo $__env->make('partials.addSpace', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php if(session('success')): ?>
                <p class="success">
                    <?php echo e(session('success')); ?>

                </p>
            <?php endif; ?>
            <?php endif; ?>
            <input type="text" id="search" placeholder="Search..." style="color: white;">
            <div id="results-users"></div>
            <?php if(Auth::check()): ?>
                <div id="results-spaces"></div>
            <?php endif; ?>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/eamachado/lbaw2372/resources/views/pages/home.blade.php ENDPATH**/ ?>