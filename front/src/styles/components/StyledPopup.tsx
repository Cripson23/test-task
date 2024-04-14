import React from 'react';
import styled, { css, keyframes } from 'styled-components';

export interface PopupProps {
    message: string;  // Сообщение в попапе
    type: 'error' | 'message';  // Тип попапа, может быть 'error' или 'message'
    onClose: () => void;  // Функция для закрытия попапа
}

const fadeIn = keyframes`
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
`;

// Стили для попапа
const PopupContainer = styled.div<Pick<PopupProps, 'type'>>`
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    min-width: 300px;
    max-width: 90%;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    animation: ${fadeIn} 0.3s ease-out;
    background-color: ${props => props.type === 'error' ? props.theme.colors.danger : props.theme.colors.success};
    color: ${props => props.theme.colors.light};
    font-size: ${props => props.theme.fontSizes.medium};

    @media (max-width: 600px) {
        font-size: ${props => props.theme.fontSizes.small};
        padding: 15px;
    }
`;

const CloseButton = styled.button`
    background: none;
    border: none;
    color: ${props => props.theme.colors.light};
    font-size: ${props => props.theme.fontSizes.large};
    cursor: pointer;
    line-height: 1;
    padding-left: 15px;

    &:hover {
        opacity: 0.8;
    }
`;

// Компонент попапа
const Popup: React.FC<PopupProps> = ({ message, type, onClose }) => (
    <PopupContainer type={type}>
        <span>{message}</span>
        <CloseButton onClick={onClose}>&times;</CloseButton>
    </PopupContainer>
);

export default Popup;