import React from "react";
import styled from "styled-components";
import { devices } from './breackpoint';

const Galerie = (props) => {
  const photo = props.photo;
  return (
    <>
      {photo["format"] === "portrait" ? (
        <Wrapper className="divContainerPortrait">
          <div className="divPortrait">
            <img
              className="portrait"
              src={photo["source"]}
              alt={photo["title"]}
            />
            <h3 className="ComputerOnly">{photo["title"]}</h3>
          </div>

          <h3 className="MobileOnly">{photo["title"]}</h3>
        </Wrapper>
      ) : (
        <Wrapper className="divContainerPaysage">
          <div className="divPaysage">
            <img className="paysage" src={photo["source"]} alt={photo["title"]} />
            <h3 className="ComputerOnly">{photo["title"]}</h3>
          </div>
          <h3 className="MobileOnly">{photo["title"]}</h3>
        </Wrapper>
      )}
    </>
  );
};

const Wrapper = styled.div`
  display:flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  div{
    overflow: hidden;
    margin: 10px;
    box-shadow: 0px 1px 15px 0px #392c1e;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  @media only screen and ${devices.mobile} {
    .MobileOnly{
      display:block;
    }
    .ComputerOnly{
      display:none;
    }
    .divPortrait{
      width: 80vw;
    }
    .divPaysage{
      width: 80vw;
      height: auto;
    }
  };
  @media only screen and ${devices.tablet} {
    .MobileOnly{
      display:none;
    }
    .ComputerOnly{
      display:block;
      opacity: 0;
      position: absolute;
      transition: 1s;
    };

    &:hover {
      .ComputerOnly{
        opacity: 1;
        transition: 0.5s;
        transition-delay: 0.5s;
        background: hsl(35, 57%, 36%, 0.5);
        padding: 10px;
        color: white;
      }
    };
    .divPortrait{
      max-width: 400px;
      height:600px;
    }
    .divPaysage{
      max-width: 1000px;
      height: auto;
    }
  };
  .portrait {
    height: 100%;
    max-height:90vh;
  }
  .paysage {
    width: 100%;
  }
  div:hover {
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
