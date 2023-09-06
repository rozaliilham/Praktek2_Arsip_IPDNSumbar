<div class="content-wrapper">
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
                            <div class="mb-3 font-weight-bold"> <?php echo $title; ?></div>
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