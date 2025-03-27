import YouTubePlayer from 'youtube-player';

$.each('.video', btn => {
    const video = $.qs('video', btn);
    btn.addEventListener('click', () => {
        if (video.paused) {
            btn.classList.add('is-active');
            video.controls = true;
            video.play();
        }
    });

    video.addEventListener('ended', () => {
        video.controls = false;
        btn.classList.remove('is-active');
    });
});

$.each('[data-ytb="container"]', container => {
    if (container) {
        const ytbCover = $.qs('[data-ytb="cover"]', container);
        const ytbVideo = $.qs('[data-ytb="video"]', container);

        const cover = {
            elem: ytbCover,
            add: () => ytbCover.classList.remove('is-hidden'),
            remove: () => ytbCover.classList.add('is-hidden'),
        };

        let player = YouTubePlayer(ytbVideo, {
            height: '100%',
            width: '100%',
            playerVars: {
                autoplay: 0,
            },
        });

        ytbCover?.addEventListener('click', () => {
            ytbCover.classList.add('is-hidden');
            player.playVideo();
        });

        player.addEventListener('onStateChange', (e) => {
            /* eslint-disable */
            switch (e.data) {
                case -1:
                case 0:
                case 5:
                    cover.add();
                    break;
                default:
                    cover.remove();
                    break;
            }
            /* eslint-enable*/
        });

        player.cueVideoById(ytbVideo.dataset.id);

        if (window.youtubeVideos) {
            window.youtubeVideos.push({ name: container.dataset.name, player: player, cover: cover });
        } else {
            window.youtubeVideos = [{ name: container.dataset.name, player: player, cover: cover }];
        }
    }
});