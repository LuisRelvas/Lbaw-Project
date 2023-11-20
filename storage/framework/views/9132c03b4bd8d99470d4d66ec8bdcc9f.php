<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Styles -->
        <link href="<?php echo e(url('css/milligram.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/app.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/user.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/home.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/space.page.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/register-login.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/admin.css')); ?>" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src=<?php echo e(url('js/app.js')); ?> defer>
            
        </script>
    </head>
    <body>
    <main>
        <header>
            <h1>
                <a href="<?php echo e(Auth::check() && Auth::user()->isAdmin(Auth::user()) ? url('/admin') : url('/homepage')); ?>"><mark class="sport">Sport</mark><mark class="hub">HUB</mark></a>
            </h1>
            <?php if(Auth::check()): ?>
                <a class="button" href="<?php echo e(url('/logout')); ?>"> Logout </a> 
                <a class="button" href="<?php echo e(url('/profile/'.Auth::user()->id)); ?>"><span><?php echo e(Auth::user()->name); ?></span></a>
            <?php else: ?> 
                <a class="button" href="<?php echo e(url('/login')); ?>"> Login </a> 
                <a class="button" href="<?php echo e(url('/register')); ?>"> Register </a>
            <?php endif; ?>
        </header>
        <section id="content">
            <?php echo $__env->yieldContent('content'); ?>
        </section>
    </main>
</body>
</html><?php /**PATH /Users/eamachado/lbaw2372/resources/views/layouts/app.blade.php ENDPATH**/ ?>