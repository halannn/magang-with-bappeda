import { computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import type { Pagination } from "@/types"; 

export function usePagination<T extends Pagination> (key:string){
  const page = usePage()
  
  const pagination = computed(() => page.props[key] as T)
  const items = computed(() => (pagination.value as T).data || [])
  const from = computed(() => (pagination.value as T).from)
  const to = computed(() => (pagination.value as T).to)
  const total = computed(() => (pagination.value as T).total)
  const currentPage = computed(()=> (pagination.value as T).current_page)
  const lastPage = computed(()=> (pagination.value as T).last_page)
  const links = computed(()=> (pagination.value as T).links)
  const firstPageUrl = computed(()=> (pagination.value as T).first_page_url)
  const prevPageUrl = computed(()=> (pagination.value as T).prev_page_url)
  const nextPageUrl = computed(()=> (pagination.value as T).next_page_url)
  const lastPageUrl = computed(()=> (pagination.value as T).last_page_url)

  function goTo(url : string | null) {
    if (url) router.get(url)
  }

  const visibleLinks = computed(() => {
    if (!Array.isArray(links.value)) return [];

    const pageLinks = links.value.filter((link) => typeof link.label === 'string' && !link.label.includes('Previous') && !link.label.includes('Next'));
    const currentIndex = pageLinks.findIndex((link) => link.active);
    const visible = [];

    if (pageLinks.length <= 5) return pageLinks;

    visible.push(pageLinks[0]);

    if (currentIndex > 2) visible.push({ label: '...', url: null });

    for (let i = currentIndex - 1; i <= currentIndex + 1; i++) {
        if (i > 0 && i < pageLinks.length - 1) {
            visible.push(pageLinks[i]);
        }
    }

    if (currentIndex < pageLinks.length - 3) visible.push({ label: '...', url: null });

    visible.push(pageLinks[pageLinks.length - 1]);

    return visible;
});

  return {
    items,
    from,
    to,
    total,
    currentPage,
    lastPage,
    links,
    visibleLinks,
    firstPageUrl,
    prevPageUrl,
    nextPageUrl,
    lastPageUrl,
    goTo
  }
}