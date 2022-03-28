import { Context } from '@nuxt/types';

const JsonBigInt = require('json-bigint');

export default function ({ $axios }: Context) {
  // TwitterのIDは大きな数値を扱うので丸められないようにする
  $axios.defaults.transformResponse = (data) => JsonBigInt.parse(data);
}

