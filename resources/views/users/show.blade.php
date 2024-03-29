@extends('layouts.app')

@section('title')
Detail User - {{ $site_name }}
@endsection


@section('header')
    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Masuk</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $masuk }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        Total Keterangan Masuk
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Telat</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $telat }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-yellow text-white rounded-circle shadow">
                            <i class="fas fa-business-time"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        Total Telat {{ $totalJamTelat }} Jam bulan Ini
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Cuti</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $cuti }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
                                <i class="fas fa-user-clock"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        Total Keterangan Cuti
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Alpha</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $alpha }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        Total Keterangan Alpha
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 mb-3">
                <div class="card shadow h-100">
                    <div class="card-header">
                        <h5 class="m-0 pt-1 font-weight-bold float-left">Detail User</h5>
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary float-right">Kembali</a>
                    </div>
                    <div class="card-body">
                        <img src="{{ asset(Storage::url($user->avatar)) }}" class="card-img mb-3" alt="{{ $user->avatar }}">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    <tr><td>NRP</td><td>: {{ $user->nrp }}</td></tr>
                                    <tr><td>Nama</td><td>: {{ $user->name }}</td></tr>
                                    <tr><td>Email</td><td>: {{ $user->email }}</td></tr>
                                    <tr><td>Sebagai</td><td>: {{ $user->getRoleNames() }}</td></tr>
                                </tbody>
                            </table>
                            <div class="float-right">
                                <a href="{{ route('users.edit',$user) }}" class="btn btn-sm btn-success" title="Ubah"><i class="fas fa-edit"></i></a>
                                @if ($user->id != auth()->user()->id)
                                    <form class="d-inline-block" action="{{ route('users.destroy',$user) }}" method="post">
                                        @csrf @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus user ini ???')"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                                <form class="d-inline-block" action="{{ route('users.password',$user) }}" method="post">
                                    @csrf @method('patch')
                                    <button type="submit" class="btn btn-sm btn-dark" onclick="return confirm('Apakah anda yakin ingin mereset password user ini ???')">Reset Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 mb-3">
                <div class="card shadow h-100">
                    <div class="card-header">
                        <h5 class="m-0 pt-1 font-weight-bold float-left">Kehadiran</h5>
                        @if ($libur == false)
                            @if (date('l') != 'Saturday' && date('l') != 'Sunday')
                                <button title="Tambah Kehadiran" type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#kehadiran">
                                    <i class="fas fa-plus"></i>
                                </button>
                            @endif
                        @endif
                        <form class="float-right d-inline-block" action="#" method="get">
                            <input type="hidden" name="bulan" value="{{ request('bulan',date('Y-m')) }}">
                            <button title="Download" type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i>
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kehadiran.cari', ['user' => $user]) }}" class="mb-3" method="get">
                            <div class="form-group row mb-3 ">
                                <label for="bulan" class="col-form-label col-sm-2">Bulan</label>
                                <div class="input-group col-sm-10">
                                    <input type="month" class="form-control" name="bulan" id="bulan" value="{{ request('bulan',date('Y-m')) }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Total Jam</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$presents->count())
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data yang tersedia</td>
                                        </tr>
                                    @else
                                        @foreach ($presents as $present)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($present->dates)) }}</td>
                                                <td>{{ $present->status }}</td>
                                                @if ($present->time_in)
                                                    <td>{{ date('H:i:s', strtotime($present->time_in)) }}</td>
                                                @else
                                                    <td>-</td>
                                                @endif
                                                @if($present->time_out)
                                                    <td>{{ date('H:i:s', strtotime($present->time_out)) }}</td>
                                                    <td>
                                                        @if (strtotime($present->time_out) <= strtotime($present->time_in))
                                                            {{ 21 - (\Carbon\Carbon::parse($present->time_in)->diffInHours(\Carbon\Carbon::parse($present->time_out))) }}
                                                        @else
                                                            @if (strtotime($present->time_out) >= strtotime($time_out . ' +2 hours'))
                                                                {{ (\Carbon\Carbon::parse($present->time_in)->diffInHours(\Carbon\Carbon::parse($present->time_out))) - 3 }}
                                                            @else
                                                                {{ (\Carbon\Carbon::parse($present->time_in)->diffInHours(\Carbon\Carbon::parse($present->time_out))) - 1 }}
                                                            @endif
                                                        @endif
                                                    </td>
                                                @else
                                                    <td>-</td>
                                                    <td>-</td>
                                                @endif
                                                <td>
                                                    <button data-id="{{ $present->id }}" type="button" class="btn btn-sm btn-success btnUbahKehadiran" data-toggle="modal" data-target="#ubahKehadiran">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="float-right">
                                {{ $presents->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold float-left">Aktivitas Kerja Pegawai {{$user->name}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('aktivitas-kerja.searchActivity') }}" method="get">
                            <input type="text" name="cari" id="cari" class="form-control mb-3" value="{{ request('cari') }}" placeholder="Cari . . ." autocomplete="off">
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="float-right">
                            {{ $schedules->links() }}
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Batas Waktu</th>
                                <th>Nama Pegawai</th>
                                <th>Aktivitas</th>
                                <th>Target</th>
                                <th>Status</th>
                                <th>Persetujuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$schedules->count())
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data yang tersedia</td>
                                </tr>
                            @else
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <th>{{ $rank++ }}</th>
                                        <td>{{ date('d M Y', strtotime($schedule->dates)) }}</td>
                                        <td>{{ date('d M Y', strtotime($schedule->due_date)) }}</td>
                                        <td>{{ $schedule->user->name }}</td>
                                        <td>{{ $schedule->activity }}</td>
                                        <td>{{ $schedule->target }}</td>
                                        <td>{{ $schedule->status }}</td>
                                        <td>{{ $schedule->approval }}</td>
                                        <td>
                                            <a href="{{ route('aktivitas-kerja.show', $schedule->id) }}" class="btn btn-sm btn-info" title="Detail User"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="kehadiran" tabindex="-1" role="dialog" aria-labelledby="kehadiranLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kehadiranLabel">Tambah Kehadiran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kehadiran.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <h5 class="mb-3">{{ date('l, d F Y') }}</h5>
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="form-group row">
                            <label for="status" class="col-form-label col-sm-3">Keterangan</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="Alpha" {{ old('status') == 'Alpha' ? 'selected':'' }}>Alpha</option>
                                    <option value="Masuk" {{ old('status') == 'Masuk' ? 'selected':'' }}>Masuk</option>
                                    <option value="Telat" {{ old('status') == 'Telat' ? 'selected':'' }}>Telat</option>
                                    <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected':'' }}>Sakit</option>
                                    <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected':'' }}>Cuti</option>
                                </select>
                                @error('status') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row" id="jamMasuk">
                            <label for="jam_masuk" class="col-form-label col-sm-3">Jam Masuk</label>
                            <div class="col-sm-9">
                                <input type="time" name="jam_masuk" id="jam_masuk" class="form-control @error('jam_masuk') is-invalid @enderror">
                                @error('jam_masuk') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ubahKehadiran" tabindex="-1" role="dialog" aria-labelledby="ubahKehadiranLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahKehadiranLabel">Ubah Kehadiran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="formUbahKehadiran" action="" method="post">
                    @csrf @method('patch')
                    <div class="modal-body">
                        <h5 class="mb-3" id="tanggal"></h5>
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="form-group row">
                            <label for="ubah_status" class="col-form-label col-sm-3">Keterangan</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="ubah_status">
                                    <option value="Alpha" {{ old('status') == 'Alpha' ? 'selected':'' }}>Alpha</option>
                                    <option value="Masuk" {{ old('status') == 'Masuk' ? 'selected':'' }}>Masuk</option>
                                    <option value="Telat" {{ old('status') == 'Telat' ? 'selected':'' }}>Telat</option>
                                    <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected':'' }}>Sakit</option>
                                    <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected':'' }}>Cuti</option>
                                </select>
                                @error('status') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row" id="jamMasuk">
                            <label for="ubah_jam_masuk" class="col-form-label col-sm-3">Jam Masuk</label>
                            <div class="col-sm-9">
                                <input type="time" name="jam_masuk" id="ubah_jam_masuk" class="form-control @error('jam_masuk') is-invalid @enderror">
                                @error('jam_masuk') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row" id="jamKeluar">
                            <label for="ubah_jam_keluar" class="col-form-label col-sm-3">Jam Keluar</label>
                            <div class="col-sm-9">
                                <input type="time" name="jam_keluar" id="ubah_jam_keluar" class="form-control @error('jam_keluar') is-invalid @enderror">
                                @error('jam_keluar') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#jamMasuk').hide();
            $('#status').on('change',function(){
                if ($(this).val() == 'Masuk' || $(this).val() == 'Telat') {
                    $('#jamMasuk').show();
                } else {
                    $('#jamMasuk').hide();
                }
            });
            $('.btnUbahKehadiran').on('click',function(){
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                const id = $(this).data('id');
                $('.formUbahKehadiran').attr('action', "{{ url('kehadiran') }}/" + id);
                $.ajax({
                    url: "{{ route('ajax.get.kehadiran') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function (data) {
                        var date = new Date(data.dates);
                        var tahun = date.getFullYear();
                        var bulan = date.getMonth();
                        var tanggal = date.getDate();
                        var hari = date.getDay();
                        var jam = date.getHours();
                        var menit = date.getMinutes();
                        var detik = date.getSeconds();
                        switch(hari) {
                            case 0: hari = "Minggu"; break;
                            case 1: hari = "Senin"; break;
                            case 2: hari = "Selasa"; break;
                            case 3: hari = "Rabu"; break;
                            case 4: hari = "Kamis"; break;
                            case 5: hari = "Jum'at"; break;
                            case 6: hari = "Sabtu"; break;
                        }
                        switch(bulan) {
                            case 0: bulan = "Januari"; break;
                            case 1: bulan = "Februari"; break;
                            case 2: bulan = "Maret"; break;
                            case 3: bulan = "April"; break;
                            case 4: bulan = "Mei"; break;
                            case 5: bulan = "Juni"; break;
                            case 6: bulan = "Juli"; break;
                            case 7: bulan = "Agustus"; break;
                            case 8: bulan = "September"; break;
                            case 9: bulan = "Oktober"; break;
                            case 10: bulan = "November"; break;
                            case 11: bulan = "Desember"; break;
                        }
                        $('#tanggal').html(hari +", "+ tanggal +" "+ bulan +" "+ tahun);
                        $('#ubah_status').val(data.status);
                        $('#ubah_jam_masuk').val(data.jam_masuk);
                        $('#ubah_jam_keluar').val(data.jam_keluar);
                    }
                });
            });
        });
    </script>
@endpush
