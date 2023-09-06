<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content">
        <div class="container-fluid">
            <!-- Default box -->
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <form class="form-inline" action="<?php echo base_url('admin/filter_kas_keluar'); ?>" method="post">
                                <label class="mb-2 mr-sm-2">Tanggal : </label>
                                <input type="date" class="form-control form-control-sm mb-2 mr-sm-2" name="tanggal" required>
                                <button type="submit" class="btn btn-primary btn-sm mb-2">Filter</button>
                            </form>
                        </div> <!-- /.card-body -->
                        <div class="card-body">
                            <div class="mb-3 font-weight-bold"> <?php echo $title; ?></div>
                            <div class="table-responsive">
                                <table class=" table table-bordered table-hover" id="table-table" style="font-size:14px;">
                                    <thead>
                                        <th>#</th>
                                        <th>No</th>
                                        <th>Outlet / Nama</th>
                                        <th>Tgl</th>
                                        <th>Jumlah</th>
                                        <th>Operator</th>
                                        <th>Operator Edit</th>
                                        <th>Keterangan</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($kas_keluar as $lu) : ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $lu['no_kas_keluar']; ?></td>
                                                <td><?php echo $lu['outlet_kas_keluar']; ?></td>
                                                <td><?php echo format_indo($lu['tgl_kas_keluar']); ?></td>
                                                <td>Rp <?php echo rupiah($lu['jml_kas_keluar']); ?></td>
                                                <td><?php echo $lu['nama']; ?></td>
                                                <td><?php echo $lu['operator_edit_kas_keluar']; ?></td>
                                                <td><?php echo $lu['ket_kas_keluar']; ?></td>
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
                    <form action="<?php echo base_url('admin/kas_keluar'); ?>" method="post" id="form_id">
                        <div class="form-group">
                            <label>No Jurnal / Kuitansi</label>
                            <input type="text" class="form-control form-control-sm" name="no_kas_keluar" required>
                        </div>
                        <div class="form-group">
                            <label>Outlet / Nama</label>
                            <input type="text" class="form-control form-control-sm" name="outlet_kas_keluar" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_kas_keluar" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <input type="text" class="form-control form-control-sm" name="jml_kas_keluar" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control form-control-sm" name="ket_kas_keluar" rows="2" required></textarea>
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
                    <form action="<?php echo base_url('admin/edit_kas_keluar'); ?>" method="post" id="form_id">
                        <input type="hidden" name="id_kas_keluar" id="id_kas_keluar">
                        <div class="form-group">
                            <label>No Jurnal / Kuitansi</label>
                            <input type="text" class="form-control form-control-sm" name="no_kas_keluar" id="no_kas_keluar" required>
                        </div>
                        <div class=" form-group">
                            <label>Outlet / Nama</label>
                            <input type="text" class="form-control form-control-sm" name="outlet_kas_keluar" id="outlet_kas_keluar" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_kas_keluar" id="tgl_kas_keluar" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <input type="text" class="form-control form-control-sm" name="jml_kas_keluar" id="jml_kas_keluar" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control form-control-sm" name="ket_kas_keluar" rows="2" id="ket_kas_keluar" required></textarea>
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
        const id_kas_keluar = $(this).data('id');
        $.ajax({
            url: '<?php echo base_url('admin/get_kas_keluar'); ?>',
            data: {
                id_kas_keluar: id_kas_keluar
            },
            method: 'post',
            dataType: 'json',
            success: function(data) {
                $('#ket_kas_keluar').val(data.ket_kas_keluar);
                $('#jml_kas_keluar').val(data.jml_kas_keluar);
                $('#tgl_kas_keluar').val(data.tgl_kas_keluar);
                $('#outlet_kas_keluar').val(data.outlet_kas_keluar);
                $('#no_kas_keluar').val(data.no_kas_keluar);
                $('#id_kas_keluar').val(data.id_kas_keluar);
            }
        });
    });
</script>