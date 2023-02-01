import React from "react";
import styled from "styled-components";

const Galerie = (props) => {
  const photo = props.photo;
  return (
    <>
      {photo["format"] === "portrait" ? (
        <Wrapper className="divPortrait">
          <img
            className="portrait"
            src={photo["source"]}
            alt={photo["title"]}
          />

          <h3>{photo["title"]}</h3>
        </Wrapper>
      ) : (
        <Wrapper className="divPaysage">
          <img className="paysage" src={photo["source"]} alt={photo["title"]} />
          <h3>{photo["title"]}</h3>
        </Wrapper>
      )}
    </>
  );
};

const Wrapper = styled.div`
  background: black;
  margin: 10px;
  box-shadow: 0px 1px 15px 0px #392c1e;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  overflow: hidden;

  h3 {
    opacity: 0;
    position: absolute;
    transition: 1s;
  }

  &:hover {
    h3 {
      opacity: 1;
      transition: 0.5s;
      transition-delay: 0.5s;
      background: hsl(35, 57%, 36%, 0.5);
      padding: 10px;
      color: white;
    }
  }
  .portrait {
    width: 100%;
  }
  .paysage {
    height: 100%;
  }
  &:hover {
    box-shadow: 0px 1px 4px 6px #392c1e;
  }
  img {
    transition: 1s;
    &:hover {
      transition: 0.8s ease;
      transform: scale(1.09);
    }
  }
`;
export default Galerie;
