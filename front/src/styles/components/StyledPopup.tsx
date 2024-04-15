import React, { useEffect, useState } from 'react';
import styled, { keyframes } from 'styled-components';

export interface PopupProps {
    message: string;
    type: 'error' | 'message';
    onClose: () => void;
    autoCloseTimeout?: number; // время в миллисекундах до автоматического закрытия
}

const fadeIn = keyframes`
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
`;

const fadeOut = keyframes`
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
`;

// Стили для попапа
const PopupContainer = styled.div<Pick<PopupProps, 'type'> & { $isVisible: boolean }>`
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    min-width: 300px;
    max-width: 90%;
    text-align: center;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    animation: ${({ $isVisible }) => $isVisible ? fadeIn : fadeOut} 0.3s ease-out forwards;
    background-color: ${props => props.type === 'error' ? props.theme.colors.danger : props.theme.colors.success};
    color: ${props => props.theme.colors.light};
    font-size: ${props => props.theme.fontSizes.medium};
`;

const CloseButton = styled.button`
    background: none;
    border: none;
    color: ${props => props.theme.colors.light};
    font-size: ${props => props.theme.fontSizes.large};
    cursor: pointer;
    line-height: 1;
    padding-left: 25px;

    &:hover {
        opacity: 0.8;
    }
`;

// Компонент попапа
const Popup: React.FC<PopupProps> = ({ message, type, onClose, autoCloseTimeout }) => {
    const [isVisible, setIsVisible] = useState(true);

    useEffect(() => {
        if (autoCloseTimeout) {
            const timer = setTimeout(() => {
                setIsVisible(false);
                setTimeout(onClose, 300);
            }, autoCloseTimeout);

            return () => clearTimeout(timer);
        }
    }, [autoCloseTimeout, onClose]);

    return (
        <PopupContainer type={type} $isVisible={isVisible}>
            <span>{message}</span>
            <CloseButton onClick={onClose}>&times;</CloseButton>
        </PopupContainer>
    );
};

export default Popup;