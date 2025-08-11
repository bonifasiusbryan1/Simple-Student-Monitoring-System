<button class="btn-custom-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><div><i class="bi bi-list"></i></div></button>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="menu">
            <a href="/dashboard/{{ auth()->user()->role }}">
                <i class="bi bi-grid"></i>
                Dashboard
            </a>
        </div>
        <div class="menu {{ $page == "generate"? "active" : "" }}">
            @if (auth()->user()->role == 'operator')
            <a href="/generate/akunmahasiswa" class="grid-generate">
                <i class="bi bi-card-checklist"></i>
                Generate Akun Mahasiswa
            </a>
            @endif
        </div>
        <div class="menu {{ $page == "entry"? "active" : "" }}">
            @if (auth()->user()->role == 'operator')
            <a href="/entry/progresstudi" class="grid-generate">
                <i class="bi bi-card-checklist"></i>
                Entry Progres Studi Mahasiswa
            </a>
            @endif
        </div>
        <div class="menu {{ $page == "irs"? "active" : "" }}">
            @if(auth()->user()->role == 'dosenwali' || auth()->user()->role == 'operator')
                <a href="/verifikasi/irs">
                    <i class="bi bi-card-checklist"></i>
                    Verifikasi Isian Rencana Studi (IRS)
                </a>
            @elseif (auth()->user()->role == 'mahasiswa')
                <a href="/irs/{{ auth()->user()->role }}">
                    <i class="bi bi-card-checklist"></i>
                    Isian Rencana Studi (IRS)
                </a>
            @endif
        </div>
        <div class="menu {{ $page == "khs"? "active" : "" }}">
            @if (auth()->user()->role == 'dosenwali' || auth()->user()->role == 'operator')
                <a href="/verifikasi/khs">
                    <i class="bi bi-award"></i>
                    Verifikasi Kartu Hasil Studi (KHS)
                </a>
            @elseif (auth()->user()->role == 'mahasiswa')
                @if ($semesterAktif > 1)
                <a href="/khs/{{ auth()->user()->role }}">
                    <i class="bi bi-award"></i>
                    Kartu Hasil Studi (KHS)
                </a>
                @endif
            @endif
        </div>
        <div class="menu {{ $page == "pkl"? "active" : "" }}">
            @if (auth()->user()->role == 'dosenwali' || auth()->user()->role == 'operator')
                <a href="/verifikasi/pkl">
                    <i class="bi bi-briefcase"></i>
                    Verifikasi Praktik Kerja Lapangan (PKL)
                </a>
            @elseif (auth()->user()->role == 'mahasiswa')
                @if (count($semesterPKL) != 0)
                <a href="/pkl/{{ auth()->user()->role }}">
                    <i class="bi bi-briefcase"></i>
                    Praktik Kerja Lapangan (PKL)
                </a>
                @endif
            @endif
        </div>
        <div class="menu {{ $page == "skripsi"? "active" : "" }}">
            @if (auth()->user()->role == 'dosenwali' || auth()->user()->role == 'operator')
                <a href="/verifikasi/skripsi">
                    <i class="bi bi-mortarboard"></i>
                    Verifikasi Skripsi
                </a>
            @elseif (auth()->user()->role == 'mahasiswa')
                @if (count($semesterSkripsi) != 0)
                <a href="/skripsi/{{ auth()->user()->role }}">
                    <i class="bi bi-mortarboard"></i>
                    Skripsi
                </a>
                @endif
            @endif
        </div>
        <div class="menu {{ $page == "progresstudi"? "active" : "" }}">
            @if (auth()->user()->role == 'dosenwali' || auth()->user()->role == 'operator' || auth()->user()->role == 'departemen')
                <a href="/progresstudi">
                    <i class="bi bi-bar-chart-line"></i>
                    Progress Studi Mahasiswa
                </a>
            @endif
        </div>
        <div class="menu {{ $page == "rekappkl" ? "active" : "" }}">
            @if (auth()->user()->role == 'dosenwali' || auth()->user()->role == 'operator' || auth()->user()->role == 'departemen')
                <a href="/rekap/mahasiswa/pkl">
                    <i class="bi bi-bookmarks"></i>
                    Rekap PKL Mahasiswa
                </a>
            @endif
        </div>
        <div class="menu {{ $page == "rekapskripsi" ? "active" : "" }}">
            @if (auth()->user()->role == 'dosenwali' || auth()->user()->role == 'operator' || auth()->user()->role == 'departemen')
                <a href="/rekap/mahasiswa/skripsi">
                    <i class="bi bi-clipboard2-data"></i>
                    Rekap Skripsi Mahasiswa
                </a>
            @endif
        </div>
        <div class="menu {{ $page == "rekapmhs" ? "active" : "" }}">
            @if (auth()->user()->role == 'dosenwali' || auth()->user()->role == 'operator' || auth()->user()->role == 'departemen')
                <a href="/rekap/mahasiswa">
                    <i class="bi bi-card-heading"></i>
                    Rekap Mahasiswa
                </a>
            @endif
        </div>        
        <div class="menu {{ $page == "profile"? "active" : "" }}">
            <a href="/profile/{{ auth()->user()->role }}">
                <i class="bi bi-person-circle"></i>
                Profile
            </a>
        </div>
    </div>
    </div>