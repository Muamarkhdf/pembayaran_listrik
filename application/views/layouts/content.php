<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?? 'Dashboard' ?></h1>
                <?php if (isset($page_breadcrumb)): ?>
                <ol class="breadcrumb">
                    <?php foreach ($page_breadcrumb as $breadcrumb): ?>
                    <li class="breadcrumb-item <?= $breadcrumb['active'] ? 'active' : '' ?>">
                        <?php if (!$breadcrumb['active']): ?>
                        <a href="<?= $breadcrumb['url'] ?>"><?= $breadcrumb['text'] ?></a>
                        <?php else: ?>
                        <?= $breadcrumb['text'] ?>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ol>
                <?php endif; ?>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Content akan di-include di sini -->
                <?php if (isset($content)): ?>
                    <?php include $content; ?>
                <?php endif; ?>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
</div> 