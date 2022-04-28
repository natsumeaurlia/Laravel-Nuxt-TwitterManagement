// 'twimg','vine','periscope','native_video'を除く。(サービス終了済みなど用途が限られるため)
export const filters = ['links', 'verified', 'images', 'videos', 'media', 'news', 'safe'] as const

type FilterValues = typeof filters[number]

type FilterDescription = Record<FilterValues, String>

export const filterDescription: FilterDescription = {
  links: 'リンクが含まれるツイート',
  verified: '認証されたアカウントからつぶやかれたツイート',
  images: '画像が含まれるツイート',
  videos: '動画が含まれるツイート',
  // twimg: 'ツイッターの画像が含まれるツイート',
  media: 'メディア(画像または動画)が含まれるツイート',
  // vine: 'Vineが含まれるツイート',
  news: 'ニュースだと思われるツイート',
  safe: 'センシティブでないツイート',
  // periscope: 'periscopeで配信しているツイート',
  // native_video: 'periscope,vineまたはTwitterにアップロードされた動画',
}

type FilterOption = typeof filters

export type { FilterOption }
