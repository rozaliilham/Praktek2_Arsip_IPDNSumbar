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
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger">
                            <a class="close" data-dismiss="alert">x</a>
                            <strong><?php echo strip_tags(validation_errors()); ?></strong>
                        </div>
                    <?php } ?>
                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-user">
                                <i class="fas fa-plus-circle"></i> Tambah Data
                            </button>
                        </div> <!-- /.card-body -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-hover" id="table-id" style="font-size:14px;">
                                    <thead>
                                        <th>#</th>
                                        <th>No</th>
                                        <th>Asal Kas</th>
                                        <th>Tgl</th>
                                        <th>Jumlah</th>
                                        <th>Operator</th>
                                        <th>Operator Edit</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
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
                                                <td>
                                                    <button type="button" class="tombol-edit btn btn-info btn-sm" data-id="<?php echo $lu['id_kas_masuk']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i></button>
                                                    <a href="<?php echo base_url('admin/hapus_kas_masuk/' . $lu['id_kas_masuk']); ?>" class="tombol-hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                                </td>
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

<!-- Modal -->
<div class="modal fade" id="add-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <form action="<?php echo base_url('admin/kas_masuk'); ?>" method="post" id="form_id">
                        <div class="form-group">
                            <label>No Jurnal / Kuitansi</label>
                            <input type="text" class="form-control form-control-sm" name="no_kas_masuk" required>
                        </div>
                        <div class="form-group">
                            <label>Outlet / Dana Asal</label>
                            <input type="text" class="form-control form-control-sm" name="outlet_kas_masuk" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_kas_masuk" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <input type="text" class="form-control form-control-sm" name="jml_kas_masuk" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control form-control-sm" name="ket_kas_masuk" rows="2" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan Data</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>

<div class="modal fade" id="edit-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <form action="<?php echo base_url('admin/edit_kas_masuk'); ?>" method="post" id="form_id">
                        <input type="hidden" name="id_kas_masuk" id="id_kas_masuk">
                        <div class="form-group">
                            <label>No Jurnal / Kuitansi</label>
                            <input type="text" class="form-control form-control-sm" name="no_kas_masuk" id="no_kas_masuk" required>
                        </div>
                        <div class=" form-group">
                            <label>Outlet / Dana Asal</label>
                            <input type="text" class="form-control form-control-sm" name="outlet_kas_masuk" id="outlet_kas_masuk" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_kas_masuk" id="tgl_kas_masuk" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <input type="text" class="form-control form-control-sm" name="jml_kas_masuk" id="jml_kas_masuk" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control form-control-sm" name="ket_kas_masuk" rows="2" id="ket_kas_masuk" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.tombol-edit').on('click', function() {
        const id_kas_masuk = $(this).data('id');
        $.ajax({
            url: '<?php echo base_url('admin/get_kas_masuk'); ?>',
            data: {
                id_kas_masuk: id_kas_masuk
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#ket_kas_masuk').val(data.ket_kas_masuk);
                $('#jml_kas_masuk').val(data.jml_kas_masuk);
                $('#tgl_kas_masuk').val(data.tgl_kas_masuk);
                $('#outlet_kas_masuk').val(data.outlet_kas_masuk);
                $('#no_kas_masuk').val(data.no_kas_masuk);
                $('#id_kas_masuk').val(data.id_kas_masuk);
            }
        });
    });
</script>