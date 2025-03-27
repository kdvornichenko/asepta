const uploader = $.qs('[data-uploader]');

if (uploader) {
    const input = $.qs('[data-uploader="input"]', uploader);
    const area = $.qs('[data-uploader="area"]', uploader);
    const maxFiles = input.dataset.max;
    const errorElem = $.qs('[data-uploader="error"]', uploader);
    const filesList = $.qs('[data-uploader="files-list"]', uploader);
    const files = () => $.qsa('[data-uploader="file"]', filesList);
    let uploadedFiles = [];

    input.addEventListener('change', () => handleFileChange());
    area.addEventListener('dragenter', event => onDragEnter(event));
    area.addEventListener('dragover', event => onDragOver(event));
    area.addEventListener('dragleave', event => onDragLeave(event));
    area.addEventListener('drop', event => onDrop(event));

    function onDragEnter(event) {
        event.stopPropagation();
        event.preventDefault();

        area.classList.add('is-hovered');
    }

    function onDragOver(event) {
        event.stopPropagation();
        event.preventDefault();

        area.classList.add('is-hovered');
    }

    function onDragLeave(event) {
        event.stopPropagation();
        event.preventDefault();

        area.classList.remove('is-hovered');
    }

    function onDrop(event) {
        event.stopPropagation();
        event.preventDefault();

        data = event.dataTransfer;
        if (!data && !data.files) {
            return false;
        }

        data.dropEffect = 'copy';

        handleFileChange(null, Array.from(data.files));
        area.classList.remove('is-hovered');
    }

    function handleFileChange(deletingIndex, files = null) {
        const dataTransfer = new DataTransfer();

        if (!deletingIndex) {
            if (files) {
                files.forEach(file => uploadedFiles.push(file));
            } else {
                Array.from(input.files).forEach(file => uploadedFiles.push(file));
            }
        } else {
            uploadedFiles = uploadedFiles.filter(file => uploadedFiles[deletingIndex] !== file);
        }

        if (uploadedFiles.length >= maxFiles) {
            uploadedFiles = uploadedFiles.slice(0, maxFiles);
        }

        for (let i = 0; i < uploadedFiles.length; i++) {
            dataTransfer.items.add(uploadedFiles[i]);
        }

        input.files = dataTransfer.files;

        setErrorMessage(input.files.length >= maxFiles);
        updateFiles();
    }

    function deleteFile(index) {
        handleFileChange(index);
        updateFilesIndexes();
    }

    function updateFilesIndexes() {
        files().forEach((file, index) => file.dataset.index = index);
    }

    function updateFiles() {
        filesList.innerHTML = '';

        Array.from(uploadedFiles).forEach((file, index) => {
            const el = document.createElement('div');

            const elName = document.createElement('div');
            const elDelete = document.createElement('span');
            const elExtention = document.createElement('span');
            const fileName = file.name.split('.');

            el.classList.add('uploader__file');
            el.dataset.index = index;
            el.dataset.uploader = 'file';

            elName.classList.add('uploader__file-name');
            elExtention.classList.add('uploader__file-extention');

            elDelete.classList.add('uploader__file-delete');
            elDelete.addEventListener('click', () => deleteFile(el.dataset.index));

            elName.textContent = fileName[0];
            elDelete.innerHTML = '<svg class="i-cross"><use xlink:href="#i-cross"></use></svg>';
            elExtention.textContent = fileName.at(-1);

            el.appendChild(elName);
            el.appendChild(elExtention);
            el.appendChild(elDelete);

            filesList.appendChild(el);
        });
    }

    function setErrorMessage(isError) {
        errorElem.textContent = isError ? `Максимально можно загрузить ${maxFiles} файлов` : '';

        isError ? input.setAttribute('disabled', 'disabled') : input.removeAttribute('disabled');
    }
}
