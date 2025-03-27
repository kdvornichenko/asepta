function buy() {
    const filters = $.qsa('[data-filter]');
    const filtersTarget = $.qsa('[data-filter-target]');
    const filterMap = new Map();

    filters.forEach(filter => {
        const filterName = filter.dataset.filter;

        if (filterName === 'reset') return;

        const target = filtersTarget.find(target => target.dataset.filterTarget === filterName);

        if (target) {
            filterMap.set(filter, target);
        } else {
            console.error(`Целевой блок не найден: ${filterName}`);
        }
    });

    // Функция для обновления видимости блоков
    const updateVisibility = () => {
        let activeFilter = null;

        // Проверяем, есть ли активный фильтр
        filterMap.forEach((target, filter) => {
            if (filter.checked) activeFilter = target;
        });

        // Проверяем, выбран ли фильтр reset
        const isResetSelected = filters.some(filter => filter.checked && filter.dataset.filter === 'reset');

        if (isResetSelected) {
            // При выобер reset отображаем все блоки
            filtersTarget.forEach(target => target.classList.remove('is-hidden'));
        } else if (!activeFilter) {
            // Если блока для выбранного фильтра нет, скрываем все блоки
            filtersTarget.forEach(target => target.classList.add('is-hidden'));
        } else {
            // Показываем только блок выбранного фильтра
            filtersTarget.forEach(target => {
                if (target === activeFilter) {
                    target.classList.remove('is-hidden');
                } else {
                    target.classList.add('is-hidden');
                }
            });
        }
    };

    filters.forEach(filter => filter.onchange = updateVisibility);

    // Инициализация состояния видимости при загрузке страницы
    updateVisibility();
}

export default buy;
