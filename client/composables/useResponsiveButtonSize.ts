import { computed, ComputedRef, useContext } from '@nuxtjs/composition-api'
import { BreakpointName } from "vuetify/types/services/breakpoint";

const sizeList = ['x-small', 'small', 'md', 'large', 'x-large'] as const;
type ButtonSize = typeof sizeList[number];

type ResponsiveButton = {
  [Key in BreakpointName]: ButtonSize
}

type ComputedSize = ComputedRef<{} | { [K in ButtonSize]: boolean }>;

export const useResponsiveButtonSize = (min?: BreakpointName) => {
  const { $vuetify } = useContext();
  const size: ComputedSize = computed(() => {
    const bk: ResponsiveButton = { xs: 'x-small', sm: 'small', md: 'md', lg: 'large', xl: 'x-large' }
    const current = bk[$vuetify.breakpoint.name];

    // 引数で指定された最小サイズとの比較
    const minBreakPoint = min ? bk[min] : null;
    if (minBreakPoint && (sizeList.indexOf(current) <= sizeList.indexOf(minBreakPoint))) {
      return min ? { [minBreakPoint]: true } : {}
    }
    return current ? { [current]: true } : {}
  })
  return { size }
}
