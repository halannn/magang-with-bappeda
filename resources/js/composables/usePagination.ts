import { computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import type { Pagination } from "@/types"; 

export function usePagination<T extends Pagination> (key:string){
  const page = usePage()
  
  const pagination = computed(() => page.props[key] as T)
  const items = computed(() => (pagination.value as any).data || [])
  const currentPage = computed(()=> (pagination.value as any).current_page)
  const lastPage = computed(()=> (pagination.value as any).last_page)
  const links = computed(()=> (pagination.value as any).links)
  const firstPageUrl = computed(()=> (pagination.value as any).first_page_url)
  const prevPageUrl = computed(()=> (pagination.value as any).prev_page_url)
  const nextPageUrl = computed(()=> (pagination.value as any).next_page_url)
  const lastPageUrl = computed(()=> (pagination.value as any).last_page_url)

  function goTo(url : string | null) {
    if (url) router.get(url)
  }

  return {
    items,
    currentPage,
    lastPage,
    links,
    firstPageUrl,
    prevPageUrl,
    nextPageUrl,
    lastPageUrl,
    goTo
  }
}