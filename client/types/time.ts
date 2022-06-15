type ZeroToNine = 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9

type OneToTwentyThree =
  | `${0}${ZeroToNine}`
  | `${1}${ZeroToNine}`
  | `${2}${0 | 1 | 2 | 3}`
type ZeroToFiftyNine = `${0 | 1 | 2 | 3 | 4 | 5}${ZeroToNine}`

export type Hi = `${OneToTwentyThree}:${ZeroToFiftyNine}`
