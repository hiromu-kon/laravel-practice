import React, { useCallback, useState, useEffect } from 'react'
import { useListenAuthState } from 'components/shared/function/Auth/AuthLisnter'

const AuthProvider = ({ children }) => {
  const { listenAuthState } = useListenAuthState()

  useEffect(() => {
    listenAuthState()
  }, [])
  return children
}

export default AuthProvider
