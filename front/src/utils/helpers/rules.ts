export const nameRules = [
  (v: string) => !!v || 'Имя обязательно для заполнения',
  (v: string) => (v.length >= 1 && v.length <= 40) || 'Имя должно содержать до 40 символов',
  (v: string) => /^[a-zA-Zа-яА-Я- ]*$/.test(v) || 'Имя может содержать только латинские и/или кириллические буквы и дефисы',
]

export const phoneRules = [
  (v: string) => !!v || 'Номер телефона обязателен для заполнения',
  (v: string) => /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/.test(v) || 'Номер должен быть заполнен',
]

export const checkboxRules = [
  (v: boolean) => !!v || 'Необходимо дать согласие на обработку персональных данных',
]

export const regexName = /^[a-zA-Zа-яА-Я- ]*$/
export const regexNumber = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/

export function validateField(field: string, regex: RegExp) {
  return field && regex.test(field)
}

export function validateLength(field: string) {
  return field && field.length >= 1 && field.length <= 40
}
