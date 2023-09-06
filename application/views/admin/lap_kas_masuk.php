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
                        <div class="card-header">
                            <form class="form-inline" action="<?php echo base_url('admin/filter_kas_masuk'); ?>" method="post">
                                <label class="mb-2 mr-sm-2">Tanggal : </label>
                                <input type="date" class="form-control form-control-sm mb-2 mr-sm-2" name="tanggal" required>
                                <button type="submit" class="btn btn-primary btn-sm mb-2">Filter</button>
                            </form>
                        </div> <!-- /.card-body -->
                        <div class="card-body">
                            <div class="mb-3 font-weight-bold">Laporan kas masuk hari ini tanggal : <?php $tanggal = date('Y/m/d');
                                                                                                    echo format_indo($tanggal); ?>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="table-table" style="font-size:14px;">
                                    <thead>
                                        <th>#</th>
                                        <th>No</th>
                                        <th>Asal Kas</th>
                                        <th>Tgl</th>
                                        <th>Jumlah</th>
                                        <th>Operator</th>
                                        <th>Operator Edit</th>
                                        <th>Keterangan</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($kas_masuk as $lu) : ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $lu['no_kas_masuk']; ?></td>
                                                <td><?php echo $lu['outlet_kas_masuk']; ?></td>
                                                <td><?php echo format_indo($lu['tgl_kas_masuk']); ?></td>
                                                <td>Rp <?php echo rupiah($lu['jml_kas_masuk']); ?></td>
                                                <td><?php echo $lu['nama']; ?></td>
                                                <td><?php echo $lu['operator_edit_kas_masuk']; ?></td>
                                                <td><?php echo $lu['ket_kas_masuk']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->