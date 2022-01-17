import React, { useCallback, useState, useEffect, useContext } from 'react'
import axios from '../../../../libs/axios'
import { useRouter } from 'next/router'
import { AxiosError, AxiosRequestConfig, AxiosResponse } from 'axios'

type USER = {
    id: number;
    name: string;
    email: string;
}

export const useHandleLogin = () => {
  const router = useRouter()

  const handleLogin: (email: string, password: string) => void = (email, password) => {
    const options: AxiosRequestConfig = {
      url: '/api/login',
      method: 'POST',
      params: {
        email,
        password
      }
    }

    axios.get('/sanctum/csrf-cookie').then((res: AxiosResponse) => {
      axios(options)
        .then((res: AxiosResponse<USER>) => {
          const user = res.data
          router.push('/')
        })
        .catch((error: AxiosError) => {
          console.log(error)
        })
    })
  }

  return {
    handleLogin
  }
}

export const useHandleLogout = () => {
  const router = useRouter()
  const options: AxiosRequestConfig = {
    url: '/api/logout',
    method: 'POST'
  }

  return () => {
    axios.get('/sanctum/csrf-cookie').then((res) => {
      axios(options)
        .then((res: AxiosResponse<boolean>) => {
        
          router.push('/login')
        })
        .catch((error: AxiosError) => {
          console.log(error)
        })
    })
  }
}

export const useHandleRegister = () => {
  const router = useRouter()
  const handleRegister = (userName: string, email: string, password: string): void => {
    const options: AxiosRequestConfig = {
      url: '/api/register',
      method: 'POST',
      params: {
        username: userName,
        email: email,
        password: password
      }
    }

    axios.get('/sanctum/csrf-cookie').then((res) => {
      axios(options)
        .then((res: AxiosResponse<USER>) => {
          const user = res.data
          router.push('/')
        })
        .catch((error: AxiosError) => {
          console.log(error)
        })
    })
  }

  return {
    handleRegister
  }
}

export const useListenAuthState = () => {
  const router = useRouter()

  const listenAuthState = (): void => {
    const options: AxiosRequestConfig = {
      url: '/api/user',
      method: 'GET'
    }

    axios(options)
      .then((res: AxiosResponse<USER>) => {
        const user = res.data
        console.log(user)

      })
      .catch((error: AxiosError) => {
        console.log(error)
      })
  }

  return {
    listenAuthState
  }
}
