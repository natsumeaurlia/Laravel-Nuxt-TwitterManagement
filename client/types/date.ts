type OneToNine = 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9
type ZeroToNine = 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9
/**
 * Years
 */
type YYYY = `19${OneToNine}${ZeroToNine}` | `20${ZeroToNine}${ZeroToNine}`
/**
 * Months
 */
type MM = `0${OneToNine}` | `1${0 | 1 | 2}`
/**
 * Days
 */
type DD = `${0}${OneToNine}` | `${1 | 2}${ZeroToNine}` | `3${0 | 1}`
/**
 * YYYY-MM-DD
 */
export type YYYYMMDD = `${YYYY}-${MM}-${DD}`
