import React from "react";
import styled from "styled-components";

const Menu = (props) => {
  const menu = props.menu;
  let affichePrice = String(menu["price"]);
  affichePrice =
    affichePrice.substring(0, affichePrice.length - 2) +
    "€" +
    affichePrice.substring(affichePrice.length - 2);

  return (
    <Wrapper>
      <h2>{menu["title"]}</h2>
      <p>{menu["description"]}</p>
      <span>{affichePrice}</span>
    </Wrapper>
  );
};

const Wrapper = styled.div`
  background: #b6ac97;
  border-radius: 25px;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 60vw;
  margin: 10px;
  padding: 10px;
  box-shadow: 0px 1px 15px 0px #392c1e;
  h2 {
    color: black;
    padding: 0;
    margin: 15px;
  }
  p {
    color: white;
    margin: 5px;
    padding: 0;
    text-align: center;
  }
  span {
    color: black;
    padding: 0;
    margin-bot: 5px;
  }
`;
export default Menu;
