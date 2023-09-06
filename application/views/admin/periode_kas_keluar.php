<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark"><?php echo $title; ?></h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Default box -->
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <form class="form-inline" action="<?php echo base_url('admin/filter_periode_kas_keluar'); ?>" method="post">
                                <label class="mb-2 mr-sm-2">Tanggal : </label>
                                <input type="date" class="form-control form-control-sm mb-2 mr-sm-2" name="tanggal_awal" required>
                                <label class="mb-2 mr-sm-2"> s/d </label>
                                <input type="date" class="form-control form-control-sm mb-2 mr-sm-2" name="tanggal_akhir" required>
                                <button type="submit" class="btn btn-primary btn-sm mb-2">Filter</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->