import { computed, reactive, SetupContext } from "@nuxtjs/composition-api";

export interface TokenForm {
  token?: String
  tokenSecret?: String
  consumerKey?: String
  consumerSecret?: String
}

export const useAccountForm = () => {
  const form = reactive<TokenForm>({ token: '', tokenSecret: '', consumerKey: '', consumerSecret: '', })
  const canSubmit = computed(() => Object.values(form).every(value => Boolean(value)));
  const initializeForm = () => {
    form.token = '';
    form.tokenSecret = '';
    form.consumerKey = '';
    form.consumerSecret = '';
  }
  return { form , canSubmit, initializeForm };
}

export const usePropAccountForm = (props: { value: TokenForm }, emit: SetupContext['emit']) => {
  const updateForm = (diff: any) => {
    emit('input', Object.assign(props.value, diff))
  }
  const token = computed({
    get: () => props.value.token,
    set: (val) => updateForm({ token: val })
  })
  const tokenSecret = computed({
    get: () => props.value.tokenSecret,
    set: (val) => updateForm({ tokenSecret: val })
  })
  const consumerKey = computed({
    get: () => props.value.consumerKey,
    set: (val) => updateForm({ consumerKey: val })
  })
  const consumerSecret = computed({
    get: () => props.value.consumerSecret,
    set: (val) => updateForm({ consumerSecret: val })
  })

  return { token, tokenSecret, consumerKey, consumerSecret };
};
