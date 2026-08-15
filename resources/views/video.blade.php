@extends('layouts.master')
@section('content')
<style>
    /* ===== MODERN DESIGN SYSTEM ===== */
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --primary-light: #818cf8;
        --success: #10b981;
        --success-dark: #059669;
        --danger: #ef4444;
        --danger-dark: #dc2626;
        --warning: #f59e0b;
        --info: #0ea5e9;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.04);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.08), 0 4px 6px rgba(0,0,0,0.04);
        --radius: 8px;
        --radius-lg: 12px;
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body { background: #f1f5f9; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }

    /* ===== BREADCRUMB ===== */
    .content-header > .breadcrumb {
        float: right;
        background: transparent;
        margin-top: 0;
        margin-bottom: 0;
        font-size: 12px;
        padding: 7px 5px;
        border-radius: 2px;
    }

    .content-header > .breadcrumb > li > a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .content-header > .breadcrumb > li > a:hover {
        color: var(--primary-dark);
    }

    .content-header h1 {
        font-size: 20px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 4px;
    }
    .content-header h1 small {
        font-size: 14px;
        color: var(--gray-500);
        font-weight: 400;
    }

    /* ===== VIDEO GRID ===== */
    .video-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
        padding: 10px 0;
    }

    .video-card {
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid var(--gray-200);
    }

    .video-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }

    .video-card .video-wrapper {
        position: relative;
        background: #000;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .video-card .video-wrapper video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .video-card .video-wrapper .play-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition);
        cursor: pointer;
    }

    .video-card .video-wrapper:hover .play-overlay {
        opacity: 1;
    }

    .video-card .video-wrapper .play-overlay i {
        font-size: 48px;
        color: white;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }

    .video-card .video-info {
        padding: 12px 16px;
        background: white;
    }

    .video-card .video-info .video-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }

    .video-card .video-info .video-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 11px;
        color: var(--gray-500);
    }

    .video-card .video-info .video-meta .badge-type {
        background: var(--gray-100);
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 9px;
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .video-card .video-info .video-meta .badge-type.video {
        background: #e0e7ff;
        color: var(--primary);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-400);
    }

    .empty-state i {
        font-size: 64px;
        display: block;
        margin-bottom: 16px;
        color: var(--gray-300);
    }

    .empty-state h4 {
        font-size: 18px;
        color: var(--gray-600);
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 13px;
        color: var(--gray-400);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .video-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }
        .video-card .video-info .video-title {
            font-size: 12px;
        }
        .content-header h1 {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .video-grid {
            grid-template-columns: 1fr;
        }
        .video-card .video-wrapper {
            aspect-ratio: 16/9;
        }
        .video-card .video-info {
            padding: 10px 14px;
        }
        .video-card .video-info .video-title {
            font-size: 11px;
        }
    }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }
    ::-webkit-scrollbar-track {
        background: var(--gray-100);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb {
        background: var(--gray-300);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: var(--gray-400);
    }
</style>

<!-- ===== BREADCRUMB ===== -->
<section class="content-header" style="padding-top: 0px;">
    <h1>Videos <small>Management</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{url('/videos')}}"><i class="fa fa-video-camera"></i> Videos</a></li>
    </ol>
    <br>
</section>

<!-- ===== MAIN CONTENT ===== -->
<div class="row">
    <div class="col-md-12">
        @if(count($results) > 0)
            <div class="video-grid">
                @foreach($results as $result)
                <div class="video-card">
                    <div class="video-wrapper">
                        <video controls preload="metadata">
                            <source src="{{asset($result->url)}}" type="{{$result->mime_type}}">
                            Your browser does not support the video tag.
                        </video>
                        <div class="play-overlay">
                            <i class="fa fa-play-circle"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <div class="video-title">{{$result->name}}</div>
                        <div class="video-meta">
                            <span class="badge-type video">
                                <i class="fa fa-video-camera"></i> Video
                            </span>
                            <span>
                                <i class="fa fa-clock-o"></i> 
                                {{-- You can add duration if available --}}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fa fa-video-camera"></i>
                <h4>No Videos Available</h4>
                <p>There are no videos uploaded yet. Please check back later.</p>
            </div>
        @endif
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== SCRIPTS ===== -->
<!-- ============================================================ -->
<script>document.title = 'Videos';</script>
<script type="text/javascript">
    $(document).ready(function() {

        setTimeout(function() { 
            $('.sr-only').click();
        }, 0.0001);

        // ===== PLAY OVERLAY CLICK =====
        $('.play-overlay').on('click', function() {
            var video = $(this).siblings('video')[0];
            if (video.paused) {
                video.play();
                $(this).fadeOut(300);
            }
        });

        // ===== VIDEO PLAY/PAUSE TOGGLE =====
        $('.video-wrapper video').on('play', function() {
            $(this).siblings('.play-overlay').fadeOut(300);
        });

        $('.video-wrapper video').on('pause', function() {
            $(this).siblings('.play-overlay').fadeIn(300);
        });

        // ===== VIDEO CLICK TO PLAY/PAUSE =====
        $('.video-wrapper video').on('click', function() {
            if (this.paused) {
                this.play();
            } else {
                this.pause();
            }
        });

        // ===== PREVENT MULTIPLE VIDEOS PLAYING SIMULTANEOUSLY =====
        $('.video-wrapper video').on('play', function() {
            $('.video-wrapper video').each(function() {
                if (this !== $(this).closest('.video-wrapper').find('video')[0]) {
                    this.pause();
                }
            });
        });

        // ===== VIDEO LOADING STATE =====
        $('.video-wrapper video').on('waiting', function() {
            $(this).closest('.video-wrapper').css('background', '#1a1a1a');
        });

        $('.video-wrapper video').on('canplay', function() {
            $(this).closest('.video-wrapper').css('background', 'transparent');
        });

    });
</script>
@endsection