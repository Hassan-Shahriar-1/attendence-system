
export default function useFilter(target, onUpdate, config = {}) {
    const vRoute = useRoute();
    const vRouter = useRouter();

    const filters = reactive(config.initial_filters || {});
    const options = reactive(config.initial_options || {});
    const options_meta = reactive(config.initial_options_meta || {});

    const applyFilter = () => {
        const query = {};
        for (const key in filters) {
            if (typeof filters[key] == "object" && filters[key].length) {
                query[key] = filters[key].join(",")
            } else if (isFinite(filters[key]) && filters[key] !== '') {
                query[key] = filters[key]
            } else if (filters[key]) {
                query[key] = filters[key]
            }
        }

        vRouter.replace({ name: vRoute.name, query: { ...vRoute.query, ...query, page: 1 } })
    };

    const resetFilter = () => {
        const query = { ...vRoute.query };

        for (const key in filters) {
            if (typeof filters[key] == 'object') {
                filters[key] = [];
            } else {
                filters[key] = "";
            }

            if (typeof filters[key] == 'number') {
                filters[key] = null
            }
            delete query[key];
        }
        vRouter.replace({ name: vRoute.name, query })
    }


    const syncFiltersWithUrl = () => {
        const query = { ...vRoute.query };
        for (const key in filters) {
            if (!(key in query)) {
                if (typeof filters[key] == "object" && filters[key].length) {
                    query[key] = filters[key].join(",")
                } else if (isFinite(filters[key]) && filters[key] !== '') {
                    query[key] = filters[key]
                } else if (filters[key]) {
                    query[key] = filters[key]
                }
            } else {
                if (typeof filters[key] == 'object') {
                    filters[key] = query[key].split(",").map(i => isFinite(i) ? parseInt(i) : i)
                } else {
                    filters[key] = query[key]
                }
            }
        }

        vRouter.replace({ name: vRoute.name, query })
    };


    const getOptionData = async (column) => {
        let query = { ...vRoute.query };

        delete query.page;
        query["column"] = column;

        // const {data, meta} = await $fetch(targetUrl, {
        //     params: query
        // })
        const res = await useAPI(target, {
            params: query
        })

        // console.log(res)

        // options[column] = res.data.map(item => {
        //     return {
        //         label: item.label,
        //         value: isFinite(item.value) ? parseInt(item.value) : item.value
        //     }
        // });
        options[column] = res.data
        options_meta[column] = { current_page: res.current_page, last_page: res.last_page }
    };

    const getNextPageOptionData = async (column) => {
        if (options_meta[column]?.last_page == options_meta[column]?.current_page) {
            return;
        }

        const query = vRoute.query;
        query["column"] = column;
        let page = options_meta[column]?.current_page ? options_meta[column].current_page + 1 : 1;

        const res = await useAPI(target, {
            params: {...query, page}
        })

        // const options_data = res.data.map(item => {
        //     return {
        //         label: item.label,
        //         value: isFinite(item.value) ? parseInt(item.value) : item.value
        //     }
        // });

        // options[column].push(...options_data);

        options[column].push(...res.data);


        options_meta[column] = { current_page: res.current_page, last_page: res.last_page }
    };

    const unwatch = watch(() => vRoute.query, onUpdate)

    onBeforeRouteLeave(() => {
        unwatch()
    })

    onMounted(() => {
        syncFiltersWithUrl()
        onUpdate()
    })

    return { filters, options, applyFilter, resetFilter, getOptionData, getNextPageOptionData }
}
